<?php
// controller representada por um class, porque estamos trabalhando com orientação a objeto
class ControllerPessoa{

    private $_method;
    private $_modelPessoa;
    private $_codPessoa;

    //instanciar o controle pessoa
    // __construct -> método construtor, 
    //ele é executado quando o obeto da classe é criado
    public function __construct($model){

        $this->_modelPessoa = $model;
        $this->_method = $_SERVER['REQUEST_METHOD'];

        //PERMITE RECEBER DADOS JSON ATRAVÉS DA REQUISIÇÃO
        $json = file_get_contents("php://input");
        $dadosPessoa = json_decode($json);

        //tratamento do cod pessoa, caso ele não tenha nenhum valor, ele irá atribuir um valor nulo
        $this->_codPessoa = $dadosPessoa->cod_pessoa ?? null;

        //$this -> sempre vai referencia ao atributo do escopo da classe
        //diferencia os atributos dos escopos da classes, das variaveis decaradas
    }

    function router(){
        switch ($this->_method) {
            case 'GET':

                if (isset($this->_codPessoa)) {
                    return $this->_modelPessoa->findById();
                }

                //get -> enviar dados de uma forma eficiente e rápido

                //o que deve acontecer se quando eu chamar o router e o metodo for get:
                return $this->_modelPessoa->findAll();
                break;

            case 'POST':
                return $this->_modelPessoa->create();
                break;

            case 'PUT':
                return $this->_modelPessoa->update();
                break; 
                
            case 'DELETE':
                return $this->_modelPessoa->delete();
                break;
            
            default:
                # code...
                break;
        }
    }
    
}

?>
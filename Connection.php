<?php
//PDO
//letra maiuscula porque é uma classe -> igual no java

class Connection{

    //aqui estão os atributos que serão manipulados
    // _ é usado para saber que é um atributo privado

    private $_dbHostname = "localhost";
    private $_dbName = "cadastro";
    private $_userName = "root";
    private $_dbPassword = "bcd127";
    private $_conn;

    //metodos ações que ela é capaz de executar
    //metodos em php é usado com a palavra function


    public function __construct(){

        //abrindo a conexão no banco de dados
        try{
            // esse PDO() é um metodo construtor da classe PDO
            $this->_conn = new PDO("mysql:host=$this->_dbHostname;dbname=$this->_dbName;", 
                                    $this->_userName,  
                                    $this->_dbPassword);

            //this apontador acessa um atributo (nesse caso é _conn)
            //SETANDO ARIBUTOS 
            //:: -> forma de acessar
            $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        }catch(PDOException $error){
            //se der algum erros ele lança um objeto da classe PDOException
            //tratando o erro
            echo "Connection error: " . $error->getMessage();
        }
    }

    public function returnConnection(){
        
        return $this->_conn;

    }
}


?>
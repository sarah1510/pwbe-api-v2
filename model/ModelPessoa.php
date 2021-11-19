<?php
    #classe
    class modelPessoa{
        //model é o que conversa com a base de dados, por isso que precisa da conexão
        #atributo
        private $_conn;
        private $_codPessoa;
        private $_nome;
        private $_sobrenome;
        private $_email;
        private $_celular;
        private $_fotografia;

        #metodo
        public function __construct($conn){

            //PERMITE RECEBER DADOS JSON ATRAVÉS DA REQUISIÇÃO
            $json = file_get_contents("php://input");
            $dadosPessoa = json_decode($json);

            //RECEBIENTO DOS DADOS DO POSTMAN

            //esse cod_pessoa é o postman que manda (recebendo do postman)
            $this->_codPessoa = $dadosPessoa->cod_pessoa ?? null;
            $this->_nome = $dadosPessoa->nome ?? null;
            $this->_sobrenome = $dadosPessoa->sobrenome ?? null;
            $this->_email = $dadosPessoa->email ?? null;
            $this->_celular = $dadosPessoa->celular ?? null;
            $this->_fotografia = $dadosPessoa->fotografia ?? null;


            //a conexão feita de fora é passada para o atributo
            $this->_conn = $conn;
        }

        public function findAll(){
            $sql = "SELECT * FROM tbl_pessoa";

            //PREPARA UM PROCESSO DE EXECUÇÃO DE INSTRUÇÃO SQL
            $stm = $this->_conn->prepare($sql);

            //EXECUTA A INSTRUÇÃO SQL
            $stm->execute();

            //DEVOLVE OS VALORES DA SELECT PARA SEREM UTILIZADOS
            return $stm->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function findById(){
            //seleciona da tabela pessoa (onde) o cod_pessoa passa algo
            $sql = "SELECT * FROM tbl_pessoa WHERE cod_pessoa = ?";

            $stm = $this->_conn->prepare($sql);

            //preparando a ?, é o número um porque é o primeiro e único
            $stm->bindValue(1, $this->_codPessoa);

            $stm->execute();

            return $stm->fetchAll(\PDO::FETCH_ASSOC);

        }

        public function create(){
            //montando sql
            $sql = "INSERT INTO tbl_pessoa (nome, sobrenome, email, celular, fotografia)
                    VALUES (?,?,?,?,?)";
            //os pontos de interrogação esta substituindo os dados
            
            $stm = $this->_conn->prepare($sql);

            //passando os valores para os pontos de interrogações acima
            $stm->bindValue(1, $this->_nome);
            $stm->bindValue(2, $this->_sobrenome);
            $stm->bindValue(3, $this->_email);
            $stm->bindValue(4, $this->_celular);
            $stm->bindValue(5, $this->_fotografia);


            if ($stm->execute()) {
                return "Success";
            }else{
                return "Error";
            }
        }

    


    }

?>


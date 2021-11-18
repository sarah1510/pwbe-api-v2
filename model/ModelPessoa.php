<?php
    #classe
    class modelPessoa{
        //model é o que conversa com a base de dados, por isso que precisa da conexão
        #atributo
        private $_conn;

        #metodo
        public function __construct($conn){
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


    }

?>


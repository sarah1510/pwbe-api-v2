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

            // $this->_nome = $_POST["nome"] ?? null;
            // $this->_sobrenome = $_POST["sobrenome"] ?? null;
            // $this->_email = $_POST["email"] ?? null;
            // $this->_celular = $_POST["celular"] ?? null;
            // $this->_fotografia = $_FILES["fotografia"]["name"] ?? null;

            //a conexão feita de fora é passada para o atributo
            $this->_conn = $conn;
        }

        public function findAll(){
            //MONTA A INSTRUÇÃO SQL (monta uma select)
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
            //? -> não sabemos os dados que virão, por isso tem o ?
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

            $extensao = pathinfo($this->_fotografia, PATHINFO_EXTENSION);
            $novoNomeArquivo = md5(microtime()) . ".$extensao";

            move_uploaded_file($_FILES["fotografia"]["tmp_name"], "../upload/$novoNomeArquivo");
            
            $stm = $this->_conn->prepare($sql);

            //passando os valores para os pontos de interrogações acima
            $stm->bindValue(1, $this->_nome);
            $stm->bindValue(2, $this->_sobrenome);
            $stm->bindValue(3, $this->_email);
            $stm->bindValue(4, $this->_celular);
            $stm->bindValue(5, $novoNomeArquivo);


            if ($stm->execute()) {
                return "Success";
            }else{
                return "Error";
            }
        }

        public function delete(){

            $sql = "DELETE FROM tbl_pessoa WHERE cod_pessoa = ?";

            $stmt = $this->_conn->prepare($sql);

            $stmt->bindValue(1, $this->_codPessoa);

            if ($stmt->execute()) {
                return "Dados excluídos com sucesso!";
            }

        }

        public function update(){

            $sql = "UPDATE tbl_pessoa SET 
            nome = ?,
            sobrenome = ?,
            email = ?,
            celular = ?,
            fotografia = ?
            WHERE cod_pessoa = ?";

            $stmt = $this->_conn->prepare($sql);

            $stmt->bindValue(1, $this->_nome);
            $stmt->bindValue(2, $this->_sobrenome);
            $stmt->bindValue(3, $this->_email);
            $stmt->bindValue(4, $this->_celular);
            $stmt->bindValue(5, $this->_fotografia);
            $stmt->bindValue(6, $this->_codPessoa);

            if ($stmt->execute()) {
                return "Dados alterados com sucesso!";
            }

        }
    }

?>


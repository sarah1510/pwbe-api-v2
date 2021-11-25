<?php 
//contato da requisições externas com a API
//Aqui recebe todas as requisições
    
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

//importando os arquivos
include('../Connection.php');
include('../model/ModelPessoa.php');
include('../controller/ControllerPessoa.php');

//abrir a conexão
//abrir objeto da classe


//abrir a conexão
$conn = new Connection();
//model criada e pronta para trabalhar
$model = new ModelPessoa($conn->returnConnection());
//controller criada e pronta para trabalhar
$controller = new ControllerPessoa($model);
// aqui, quando criamos o objeto, na vdd estamos chamando o método construtor

// variavel que recebe o controler
//trabalho de roteamento
$dados = $controller->router();

echo json_encode(array("status"=>"Success", "data"=>$dados));

//qualquer requisição http que bater no localhost/api-senai-v2/ vai cair nesse index
 
?>
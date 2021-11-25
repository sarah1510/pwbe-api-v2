<?php
    //serviu como testes no início
    include('./Connection.php');
    include('./model/ModelPessoa.php');

    $conn = new Connection();
    $modelPessoa = new ModelPessoa($conn->returnConnection());


    $dados = $modelPessoa->findAll();

    echo'<pre>';
    var_dump($dados);
    echo'</pre>';


    // echo'<pre>';
    // var_dump($conn->returnConnection());
    // echo'</pre>';

?>
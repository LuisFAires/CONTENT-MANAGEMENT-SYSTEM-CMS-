<?php
    //BUSCA OS DADOS DAS MENAGENS DENTRO DO BANCO DE DADOS E UTILIZA VIEW.PHP
    //E UTILIZA VIEW.PHP PARA MONTAR A INTERFACE DA PÁGINA

    require_once "./connection.php";
    require_once "./functions.php";
    
    $sql = "select * from mensagens where id = ".mysqli_real_escape_string($connection, $_GET['id']);
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) == 1){
        while($row = mysqli_fetch_assoc($result)){
            $post[] = $row;
        }
    }else{
        //SE A MENSAGEM NÃO FOR ENCONTRADA REDIRECIONA O USUÁRIO PARA PÁGINA INICIAL
        header("Location:/");
    }

    require_once "./view.php";
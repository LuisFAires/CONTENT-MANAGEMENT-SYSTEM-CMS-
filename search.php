<?php
    require_once "connection.php";
    require_once "functions.php";
    $search = file_get_contents('php://input');
    $search = mysqli_real_escape_string($connection, $search);
    $lastweek = time() - 604800; 
    $sql = "SELECT COUNT(id_mensagem),id,titulo,texto,img,imgbg,cor1 FROM mensagens LEFT JOIN visualizacoes on visualizacoes.id_mensagem = mensagens.id AND data > $lastweek where titulo like '%$search%' or texto like '%$search%' GROUP BY mensagens.id ORDER BY COUNT(id_mensagem) DESC";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) == 0){
        //exibe a informação que nenhum resultado foi encontrado
        echo '<br><span class="padding2">Nenhum resultado encontrado para "'.$search.'"</span>';
    }else{
        //Exibe o número de resultados da pesquisa
        echo '<br><span class="padding2">'.mysqli_num_rows($result).' resultado(s) encontrados para "'.$search.'"</span>';
    }

    $ad = getAd();

    imprimeResultado($result, $ad); 
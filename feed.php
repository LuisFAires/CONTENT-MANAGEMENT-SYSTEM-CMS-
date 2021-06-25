<?php
    require_once "./connection.php";
    require_once "./functions.php";

    $inicio = mysqli_real_escape_string($connection, file_get_contents('php://input'));
    if($inicio == 0){
        echo '<br><span class="padding2">Destaques da última semana.</span>';
    }
    $lastweek = time() - 604800;
    $itensporpg = 10;
    $inicio = $inicio*$itensporpg;
    $sql = "SELECT COUNT(id_mensagem),id,titulo,texto,img,imgbg,cor1 FROM mensagens LEFT JOIN visualizacoes on visualizacoes.id_mensagem = mensagens.id AND data > $lastweek GROUP BY mensagens.id ORDER BY COUNT(id_mensagem) DESC limit $inicio, $itensporpg";
    $result = mysqli_query($connection, $sql);

    $ad = getAd();

    imprimeResultado($result, $ad);
<?php
    require_once "./connection.php";
    $inicio = mysqli_real_escape_string($connection, file_get_contents('php://input'));
    $lastweek = time() - 604800;
    $itensporpg = 10;
    $inicio = $inicio*$itensporpg;
    $sql = "SELECT id,titulo,texto,img,imgbg,cor1 FROM mensagens LEFT JOIN visualizacoes on id_mensagem = id AND data > $lastweek GROUP BY id ORDER BY COUNT(id_mensagem) DESC limit $inicio, $itensporpg";
    $result = mysqli_query($connection, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }

    if(isset($rows)){
        echo json_encode($rows);
    }
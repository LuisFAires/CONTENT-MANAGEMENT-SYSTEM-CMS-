<?php
    require_once "connection.php";
    $search = file_get_contents('php://input');
    $search = mysqli_real_escape_string($connection, $search);
    $lastweek = time() - 604800; 
    $sql = "SELECT id,titulo,texto,img,imgbg,cor1 FROM mensagens LEFT JOIN visualizacoes on id_mensagem = id AND data > $lastweek WHERE titulo LIKE '%$search%' OR texto LIKE '%$search%' GROUP BY id ORDER BY COUNT(id_mensagem) DESC";
    $result = mysqli_query($connection, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    if(isset($rows)){
        echo json_encode($rows);
    }
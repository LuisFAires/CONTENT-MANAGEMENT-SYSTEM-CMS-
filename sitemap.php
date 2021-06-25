<?php
    require_once "./connection.php";
    $sql  = "select id, titulo from mensagens";
    $result = mysqli_query($connection, $sql);
    header("Content-Type: application/xml; charset=utf-8");

    echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL; 
    
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;
    
    echo '<url>' . PHP_EOL;
    echo '<loc>'.$_SERVER['HTTP_HOST'].'</loc>' . PHP_EOL;
    echo '</url>' . PHP_EOL;

    echo '<url>' . PHP_EOL;
    echo '<loc>'.$_SERVER['HTTP_HOST'].'/about.php</loc>' . PHP_EOL;
    echo '</url>' . PHP_EOL;

    echo '<url>' . PHP_EOL;
    echo '<loc>'.$_SERVER['HTTP_HOST'].'/contact.php</loc>' . PHP_EOL;
    echo '</url>' . PHP_EOL;

    echo '<url>' . PHP_EOL;
    echo '<loc>'.$_SERVER['HTTP_HOST'].'/privacy.php</loc>' . PHP_EOL;
    echo '</url>' . PHP_EOL;

    while($row = mysqli_fetch_array($result)){
        echo '<url>' . PHP_EOL;
        echo '<loc>'.htmlspecialchars($_SERVER['HTTP_HOST'].'/mensagem.php?id='.$row['id'].'&titulo='.urlencode($row['titulo'])).'</loc>' . PHP_EOL;
        echo '</url>' . PHP_EOL;
    }
    
    echo '</urlset>' . PHP_EOL;
?>
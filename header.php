<?php

//CABEÇALHO

//FORÇA O USO DE HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    if(!headers_sent()) {
    header("Status: 301 Moved Permanently");
    header(sprintf(
    'Location: https://%s%s',
    $_SERVER['HTTP_HOST'],
    $_SERVER['REQUEST_URI']
    ));
    exit();
    }
}

//CARREGA AS CONFIGURAÇÕES
require_once "connection.php";
$sql = "select * from conf";
$result = mysqli_query($connection, $sql);
if(mysqli_num_rows($result) == 1){
    $result = mysqli_fetch_array($result);
    $Nome = $result['Nome'];
    $Descrição = $result['Descrição'];
    $Política = $result['Política'];
    $Sobre = $result['Sobre'];
    $tags = $result['Botões'];
    $Logo = $result['Logo'];
    $head = $result['head'];
    $manutencao = $result['manutencao'];
    $ad = $result['ad'];
}


require_once "functions.php";
get_client_ip($connection);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php if(isset($titulo)){echo $titulo." - ";} if(isset($_GET['search']) && $_GET['search'] != ""){ echo $_GET['search']." - ";} echo $Nome ?></title>
    <meta id="description" name="description" content="<?php echo $Nome." - "; echo $Descrição; if(isset($texto)){echo " - ".$texto;} ?>">
	<meta name="keywords" content="<?php echo $Nome." - "; echo $Descrição; if(isset($titulo)){echo " - ".$titulo;}if(isset($texto)){echo " - ".$texto;} ?>">
    <meta name="application-name" content="<?php echo $_SERVER['HTTP_HOST'] ?>">
    <meta name="creator" content="Luis Fillipe Aires Souza">
    <meta property="og:title" content="<?php if(isset($titulo)){echo $titulo." - ";} echo $Nome; ?>">
    <meta property="og:type" content="article">
    <meta property="og:description" content="<?php echo $Nome." - "; echo $Descrição; if(isset($texto)){echo " - ".$texto;} ?>">
    <meta property="og:image" content="<?php if(isset($img) && $img != "./img/"){echo "http://".$_SERVER['HTTP_HOST'].substr($img, 1);} ?>">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="icon" href="/icon/<?php echo $Logo?>">
    <?php echo $head; ?>
    <script>
        let ad = <?php echo json_encode($ad); ?>;
    </script>
</head>
<body>

<?php
    if($manutencao){
        paginamanutencao($Logo);    
    }
?>

<header class="header">
    <a href="/">
        <div class="inlineBlock center" style="height:100px; width:17%;">
            <img src="../icon/<?php echo $Logo; ?>" data-src="../icon/<?php echo $Logo; ?>" class="height100" alt="logo <?php echo $Nome; ?>">
        </div>
    </a>
    <form class="searchForm float" method="get" action="../">
            <input class="searchInput width100 bigFont" type="search" name="search" placeholder="Pesquisar...">
            <button class="searchButton width100 bigFont" type="submit">&#128269;</button>
    </form>

    <br>
    <nav class="center">
        <?php
            $tag = explode(",", $tags);
            foreach($tag as $i){
                echo '<a href="../?search='.$i.'"><div class="tags colorWhite inlineBlock padding10 cursor borderRadius bold">'.$i.'</div></a>';
            }
        ?>
    </nav>
    <br>
    <a href="/">
        <div class="headerButtons cursor inlineBlock padding2 center bold">Home</div>
    </a>
    <a href="/">
        <h1  class="bold bigFont inlineBlock center"style="width: 81%; margin: 5px 0;">
            <?php echo $Nome; ?>
        </h1>
    </a>
</header>

<div id="aceite" class="aceite width100 center">
    <div style="margin: 15px">A sua permanência e interação neste site será considerada como aceite da <a href="./privacy.php">política de privacidade e cookies.</a></div>
    <div id="okButton" class="okButton colorWhite cursor borderRadius inlineBlock">OK</div>
</div>
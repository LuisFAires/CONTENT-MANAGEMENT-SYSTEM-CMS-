<head>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<?php
    require_once "checkLogin.php";
    require_once "connection.php";
    require_once "admFunctions.php";    
    if(isset($_POST['titulo'], $_POST['texto'], $_FILES['img'], $_FILES['imgbg'], $_POST['cor1'], $_POST['cor2']) && $_POST['form_name'] === "Cadastrar"){
        $img = fileUpload($_FILES['img'], "../img/");
        if($img != false){
            $img = $img['img'];
        }
        $imgbg = fileUpload($_FILES['imgbg'], "../imgbg/");
        if($imgbg != false){
            $imgbg = $imgbg['img'];
        }
        databaseInsert($connection, $img,$imgbg);
    }
    echo '<br><a href="./"><button class="cornerButton ">Voltar</button></a>';
?>
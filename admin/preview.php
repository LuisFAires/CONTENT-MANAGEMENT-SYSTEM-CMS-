<?php
    require_once "./checkLogin.php";
    require_once "../functions.php";
    require_once "./admFunctions.php";

    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];
    $cor1 = $_POST['cor1'];
    $cor2 = $_POST['cor2'];
    $inversocor1 = color_inverse($cor1);
    if(isset($_POST['choiceimg']) && $_POST['choiceimg'] == "Alterar"){
        $img = "../img/".$_POST['img'];
    }else{
        $img = fileUpload($_FILES['img'], "./temp/");
        $img = $img['path'].$img['img'];
    }
    if(isset($_POST['choiceimgbg']) && $_POST['choiceimgbg'] == "Alterar"){
        $imgbg = "../imgbg/".$_POST['imgbg'];
    }else{
        $imgbg = fileUpload($_FILES['imgbg'], "./temp/");
        $imgbg = $imgbg['path'].$imgbg['img'];
    }

    require_once "../view.php";
    
    
    $path = "./temp/";
    $diretorio = dir($path);
    while($arquivo = $diretorio -> read()){
        if(time() - filectime($path.$arquivo) > 10 && $arquivo != "." && $arquivo != ".."){
            if(!unlink($path.$arquivo)){
                echo "<b class='colorRed'> Não foi encontrado arquivo nenhum arquivo na pasta temp!!!</b>";
            }
        }
    }



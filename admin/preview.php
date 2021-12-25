<?php
    require_once "./checkLogin.php";
    require_once "../functions.php";
    require_once "./admFunctions.php";

    $rows = [];
    $rows[0]['titulo'] = $_POST['titulo'];
    $rows[0]['texto'] = $_POST['texto'];
    $rows[0]['cor1'] = $_POST['cor1'];
    $rows[0]['cor2'] = $_POST['cor2'];
    if(isset($_POST['choiceimg']) && $_POST['choiceimg'] == "Alterar"){
        $rows[0]['img'] = $_POST['img'];
    }else{
        $rows[0]['img'] = fileUpload($_FILES['img'], "./temp/");
        $rows[0]['img'] = $img['path'].$img['img'];
    }
    if(isset($_POST['choiceimgbg']) && $_POST['choiceimgbg'] == "Alterar"){
        $rows[0]['imgbg'] = $_POST['imgbg'];
    }else{
        $rows[0]['imgbg'] = fileUpload($_FILES['imgbg'], "./temp/");
        $rows[0]['imgbg'] = $imgbg['path'].$imgbg['img'];
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



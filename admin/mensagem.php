<?php
    require_once "./checkLogin.php";
    require_once "./connection.php";
    require_once "../functions.php";
    require_once "./admFunctions.php";
    $sql = "select * from mensagens where id = ".$_GET['id'];
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) == 1){
        $result = mysqli_fetch_array($result);
        $titulo = $result['titulo'];
        $texto = $result['texto'];
        $img = $result['img'];
        $imgbg = $result['imgbg'];
        $cor1 = $result['cor1'];
        $cor2 = $result['cor2'];
        $inversocor1 = color_inverse($cor1);
    }else{
        echo "<br><b>   Registro não encontrado ou excluido</b><br>";
        echo '<a href="./"><button class="cornerButton ">Voltar</button></a>';
        exit();
    }

    if(isset($_POST['Delete']) && $_POST['Delete'] == "Delete"){
        databaseDelete($connection, $img, $imgbg);
    }

    if(isset($_POST['Editar']) && $_POST['Editar'] == "Editar"){
        databaseUpdate($connection, $img, $imgbg);
    }
?>
<head>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<div class="padding2">
    <a href="./"><button class="cornerButton ">Voltar</button></a>
    <button id="deleteButton" class="float cornerButton" style="background-color: #f00" >Delete</button><br><br>
    <b>Editar registro no banco de dados:</b>
    <form id="deleteForm" method="post">
       <input type="hidden" name="Delete" value="Delete">
    </form>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="Editar" value="Editar">

        <label for="titulo">Título</label><br>
        <input id="titulo" class="formCadastro width100" type="text" name="titulo" value="<?php echo $titulo;?>"><br>

        <label for="texto">Texto</label><span class="float" id="counter"></span><br>
        <textarea id="texto" class="formCadastro width100" name="texto" oninput="setCounter()"><?php echo $texto;?></textarea><br>

        <label for="img">Imagem cabeçalho</label>
        <input id="alterarimg" type="radio" name="choiceimg" value="Alterar"checked>
        <label for="alterarimg">Alterar registro</label>
        <input id="substituirimg" type="radio" name="choiceimg" value="Substituir">
        <label for="substituirimg">Substituir imagem</label><br>
        <input id="img" class="formCadastro width100" name="img" value="<?php echo $img;?>"><br>

        <label for="imgbg">Imagem fundo</label>
        <input id="alterarimgbg" type="radio" name="choiceimgbg" value="Alterar"checked>
        <label for="alterarimgbg">Alterar registro</label>
        <input id="substituirimgbg" type="radio" name="choiceimgbg" value="Substituir">
        <label for="substituirimgbg">Substituir imagem</label><br>
        <input id="imgbg" class="formCadastro width100" name="imgbg" value="<?php echo $imgbg;?>"><br>

        <label for="cor1">Cor fonte principal</label><br>
        <input id="cor1" class="formCadastro width100" type="color" name="cor1" value="<?php echo $cor1;?>"><br>

        <label for="cor2">Cor fonte secundaria</label><br>
        <input id="cor2" class="formCadastro width100" type="color" name="cor2" value="<?php echo $cor2;?>"><br>

        <br>
        <input class="cornerButton" type="submit" value="Vizualizar" formaction="./preview.php">
        <input class="cornerButton float" type="submit"><br>
        <script>
            function setCounter(){
                counter.innerHTML = texto.value.length;
            }
            setCounter()
        </script>
    </form>
</div>
<script>
    window.onload = function(){
        if(alterarimg.checked == true){
            img.type = "text";
        }
        if(substituirimg.checked == true){
            img.type = "file";
        }
        if(alterarimgbg.checked == true){
            imgbg.type = "text";
        }
        if(substituirimgbg.checked == true){
            imgbg.type = "file";
        }
    }

    deleteButton.onclick = function(){
        if(confirm("Tem certeza que deseja excluir este registro???") == true){
            deleteForm.submit();
        }else{
        }
    }


    alterarimg.onclick = function(){
        img.type = "text";
    }
    substituirimg.onclick = function(){
        img.type = "file";
    }
    alterarimgbg.onclick = function(){
        imgbg.type = "text";
    }
    substituirimgbg.onclick = function(){
        imgbg.type = "file";
    }
</script>
</body>
</html>


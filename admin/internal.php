<?php
    require_once "checkLogin.php";
    require_once "connection.php";
    require_once "admFunctions.php";
    require_once "../functions.php";
    $sql = "select * from conf";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) == 1){
        $result = mysqli_fetch_array($result);
        $Nome = $result['Nome'];
        $Descrição = $result['Descrição'];
        $Política = $result['Política'];
        $Sobre = $result['Sobre'];
        $Botões = $result['Botões'];
        $Logo = $result['Logo'];
        $head = $result['head'];
        $manutencao = $result['manutencao'];
        $ad = $result['ad'];
    }else{
        echo "<br><b>   Registro não encontrado ou excluido</b><br>";
        echo '<a href="./"><button class="cornerButton ">Voltar</button></a>';
    }
?>
<head>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<header class="header">
    <div class="headerButtons padding10 cursor inlineBlock center" onclick="showContent(this.innerHTML)">Cadastrar</div>
    <div class="headerButtons padding10 cursor inlineBlock center" onclick="showContent(this.innerHTML)">Alterar/excluir</div>
    <div class="headerButtons padding10 cursor inlineBlock center" onclick="showContent(this.innerHTML)">Contato</div>
    <div class="headerButtons padding10 cursor inlineBlock center" onclick="showContent(this.innerHTML)">Configurações</div>
    <a href="./logout.php"><div class="logout colorWhite padding10 float center" >Sair</div></a>
</header>
<div id="Cadastrar" class="contentDiv padding2">
    <form method="post" enctype="multipart/form-data" action="insert.php">
        <input class="formCadastro width100" type="hidden" name="form_name" value="Cadastrar">
        <label for="titulo">Título</label><br>
        <input id="titulo" class="formCadastro width100" type="text" name="titulo" required><br>
        <label for="texto">Texto</label><br>
        <textarea id="texto" class="formCadastro width100" name="texto"required></textarea ><br>
        <label for="img">Imagem cabeçalho</label><br>
        <input id="img" class="formCadastro width100" type="file" name="img" ><br>
        <label for="imgbg">Imagem fundo</label><br>
        <input id="imgbg" class="formCadastro width100" type="file" name="imgbg" ><br>
        <label for="cor1">Cor fonte principal</label><br>
        <input id="cor1" class="formCadastro width100" type="color" name="cor1" value="#ffffff" required><br>
        <label for="cor2">Cor fonte secundaria</label><br>
        <input id="cor2" class="formCadastro width100" type="color" name="cor2" value="#00ff00" required><br><br>
        <input class="formCadastro width100 cornerButton float" type="submit">
        <input class="formCadastro width100 cornerButton" type="submit" value="Vizualizar" formaction="./preview.php">
    </form>
</div>
<div id="Alterar/excluir" class="contentDiv padding2">
    <br>
    <form method="get">
        <input class="searchInput width100 bigFont" type="search" name="search" placeholder="Pesquisar">
        <button class="searchButton width100 bigFont" type="submit">&#128269</button>
    </form>
    <div id="principal">
    </div>
    <script>
    var msg = document.getElementsByClassName("msg");
    var counter = document.getElementsByClassName("counter");
    for(let i = 0; i < msg.length; i++){
        counter[i].innerText = "Caracteres: "+msg[i].innerText.length+" Palavras: "+msg[i].innerText.split(" ").length;
    }
    </script>
</div>
<div id="Contato" class="contentDiv padding2">
    Ultimas informações recebidas:<br><br>
    <?php
        imprimeContacts($connection);
    ?>
</div>
<div id="Configurações" class="contentDiv padding2">
    <form method="post" enctype="multipart/form-data" action="logoupdate.php">
        <label for="logo">Imagem logo</label>
        <input id="logo" class="formCadastro width100" type="file" name="logo" required><br>
        <input class="formCadastro width100" type="submit">
    </form>
    <br>
    <br>
    <form method="post" enctype="multipart/form-data" action="confupdate.php">
        <label for="Nome">Nome do site</label><br>
        <input id="Nome" class="formCadastro width100" type="text" name="Nome" value="<?php echo $Nome?>"required><br>
        <label for="Descrição">Descrição</label><br>
        <textarea id="Descrição" class="formCadastro width100" name="Descrição"required><?php echo $Descrição?></textarea ><br>
        <label for="Política">Política de privacidade</label><br>
        <textarea id="Política" class="formCadastro width100" name="Política"required><?php echo $Política?></textarea ><br>
        <label for="Sobre">Sobre:</label><br>
        <textarea id="Sobre" class="formCadastro width100" name="Sobre"required><?php echo $Sobre?></textarea ><br>
        <label for="Botões">Botões inicio</label><br>
        <textarea id="Botões" class="formCadastro width100" name="Botões"required><?php echo $Botões?></textarea ><br>
        <label for="head">Conteúdo head</label><br>
        <textarea id="head" class="formCadastro width100" name="head"><?php echo $head?></textarea ><br>
        <label for="ad">Código AdSense</label><br>
        <textarea id="ad" class="formCadastro width100" name="ad"><?php echo $ad?></textarea ><br>
        <label for="manutecao">Manutenção</label>
        <select type="checkbox" id="manutecao" class="formCadastro width100" name="manutecao"required>
            <option value="1" <?php if($manutencao == 1){echo "selected='selected'";} ?>>Sim</option>
            <option value="0" <?php if($manutencao == 0){echo "selected='selected'";} ?>>Não</option>
        </select><br>
        <input class="formCadastro width100" type="submit">
    </form>
</div>
</body>
<script src="../main.js"></script>
<script>
    var headerButtons = document.getElementsByClassName("headerButtons");
    var content = document.getElementsByClassName("contentDiv");
    hideAll();
    var toShow = getCookie("Last");
    showContent(toShow);

    function hideAll(){
        for(var i = 0; i < content.length; i++){
            content[i].style = "display: none;";
        }
    }

    function clearNav(){
        for(var i = 0; i < headerButtons.length; i++){
            headerButtons[i].style = "background: #777;";
        }
    }
    function setNav(toSet){
        for(var i = 0; i < headerButtons.length; i++){
            if(headerButtons[i].innerText == toSet){
                headerButtons[i].style = "background: #aaa; color: #000;";
            }
        }
    }
    
    function showContent(toShow){
        document.cookie = "Last="+toShow;
        hideAll();
        clearNav();
        setNav(toShow);
        var obj = document.getElementById(toShow);
        obj.style = "display: block;";
    }
</script>
</html>
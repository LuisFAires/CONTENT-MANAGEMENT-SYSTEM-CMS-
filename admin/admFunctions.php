<?php
    require_once "checkLogin.php";
    
    function fileUpload($file, $path){
        //verifica se há erro no upload das imagens;
        if($file['error'] != 0){
            print "<span class='colorRed'>erro no upload da imagem</span><br>";
            return false;
        }else{
            print "<span class='colorGreen'>upload da imagem efetuado com sucesso</span><br>";
        }
        //move os arquivos para pasta de destino
        $extension = pathinfo($file['name']);
        $img = uniqid().".".$extension['extension'];
        if(move_uploaded_file($file['tmp_name'], $path.$img)){
            print "<span class='colorGreen'>imagem movida com sucesso</span><br>";
        }else{
            print "<span class='colorRed'>erro no mover imagem</span><br>";
            return false;
        }
        $array = [
            "img" => $img,
            "path" => $path
        ];

        return $array;
    }

    function logoUpdate($connection){
        if(isset($_FILES['logo'])){

            $upload = fileUpload($_FILES['logo'], "../icon/");
            $upload = $upload['img'];

            $sql = "select logo from conf";
            $logo = mysqli_query($connection, $sql);
            $logo = mysqli_fetch_array($logo);
            $logo = $logo['logo'];
            unlink("../icon/".$logo);
            
            $sql = "update conf set Logo = '$upload'";
            mysqli_query($connection, $sql);
            $affected_row = mysqli_affected_rows($connection);
            if($affected_row == 1){
                print "<span class='colorGreen'>Registro atualizado com sucesso!</span>";
                echo '<a href="./"><button class="cornerButton ">Voltar</button></a>'; 
                exit();
            }else{
                print "<span class='colorRed'>Erro ao atualizar registro</span>";
                echo '<a href="./"><button class="cornerButton ">Voltar</button></a>';  
                exit();
            }
        }
    }

    function confUpdate($connection){
        $Nome = mysqli_real_escape_string($connection, htmlspecialchars($_POST['Nome']));
        $Descrição = mysqli_real_escape_string($connection, htmlspecialchars($_POST['Descrição']));
        $Política = mysqli_real_escape_string($connection, htmlspecialchars($_POST['Política']));
        $Sobre = mysqli_real_escape_string($connection, htmlspecialchars($_POST['Sobre']));
        $Botões = mysqli_real_escape_string($connection, htmlspecialchars($_POST['Botões']));
        $head = mysqli_real_escape_string($connection, $_POST['head']);
        $manutencao = mysqli_real_escape_string($connection, htmlspecialchars($_POST['manutecao']));
        $ad = mysqli_real_escape_string($connection, $_POST['ad']);
        $sql = "UPDATE conf SET Nome = '$Nome', Descrição = '$Descrição', Política = '$Política', Sobre = '$Sobre', Botões = '$Botões', head = '$head', manutencao = '$manutencao', ad = '$ad'";
        mysqli_query($connection, $sql);
        $affected_row = mysqli_affected_rows($connection);
        if($affected_row == 1){
            print "<span class='colorGreen'>Registro atualizado com sucesso!</span>";
            echo '<a href="./"><button class="cornerButton ">Voltar</button></a>'; 
            exit();
        }else{
            print "<span class='colorRed'>Erro ao atualizar registro</span>";
            echo '<a href="./"><button class="cornerButton ">Voltar</button></a>';  
            exit();
        }
    }

    function databaseInsert($connection, $img, $imgbg){
        $titulo = mysqli_real_escape_string($connection, htmlspecialchars($_POST['titulo']));
        $texto = mysqli_real_escape_string($connection, htmlspecialchars($_POST['texto']));
        $cor1 = mysqli_real_escape_string($connection, htmlspecialchars($_POST['cor1']));
        $cor2 = mysqli_real_escape_string($connection, htmlspecialchars($_POST['cor2']));
        $sql = "insert into mensagens (titulo, texto, img, imgbg, cor1, cor2) values ('$titulo','$texto','$img','$imgbg','$cor1','$cor2')";
        mysqli_query($connection, $sql);
        $affected_row = mysqli_affected_rows($connection);
        echo mysqli_error($connection);
        if($affected_row == 1){
            print "<span class='colorGreen'>Registro efetuado com sucesso!</span>";
        }else{
            print "<span class='colorRed'>Erro ao inserir registro</span>";
        }
    }

    function databaseDelete($connection, $img, $imgbg){
        $id = mysqli_real_escape_string($connection, $_GET['id']);
        $sql = "DELETE FROM mensagens WHERE id = $id";
        if(unlink("../img/".$img) && unlink("../imgbg/".$imgbg)){
            echo "<b class='colorGreen'>   Imagens excluidas com sucesso!!!</b><br>";
        }else{
            echo "<b class='colorRed'>   ERRO na exclusão das imagens!!!</b><br>";
        }
        if(mysqli_query($connection, $sql)){
            echo "<b class='colorGreen'>   Registro excluido com sucesso!!!</b><br>";
            echo '<a href="./"><button class="cornerButton ">Voltar</button></a>';
            exit();
        }else{
            echo "<b class='colorRed'>   ERRO!!! feche a janela atual e verifique se o registro foi excluido!!!</b><br>";
            echo '<a href="./"><button class="cornerButton ">Voltar</button></a>';  
            exit();
        }
    }

    Function databaseUpdate($connection, $img, $imgbg){
        $id = mysqli_real_escape_string($connection, htmlspecialchars($_GET['id']));
        $titulo = mysqli_real_escape_string($connection, htmlspecialchars($_POST['titulo']));
        $texto = mysqli_real_escape_string($connection, htmlspecialchars($_POST['texto']));
        $cor1 = mysqli_real_escape_string($connection, htmlspecialchars($_POST['cor1']));
        $cor2 = mysqli_real_escape_string($connection, htmlspecialchars($_POST['cor2']));
        if($_POST['choiceimg'] == "Alterar"){
            $img = mysqli_real_escape_string($connection, htmlspecialchars($_POST['img']));
        }else{
            unlink("../img/".$img);
            $img = fileUpload($_FILES['img'], "../img/");
            $img = $img['img'];
        }
        if($_POST['choiceimgbg'] == "Alterar"){
            $imgbg = mysqli_real_escape_string($connection, htmlspecialchars($_POST['imgbg']));
        }else{
            unlink("../imgbg/".$imgbg);
            $imgbg = fileUpload($_FILES['imgbg'], "../imgbg/");
            $imgbg = $imgbg['img'];
        }
        $sql = "UPDATE mensagens SET titulo = '$titulo', texto = '$texto', cor1 = '$cor1', cor2 = '$cor2', img = '$img', imgbg = '$imgbg' WHERE id = $id";
        mysqli_query($connection, $sql);
        $affected_row = mysqli_affected_rows($connection);
        if($affected_row == 1){
            print "<span class='colorGreen'>Registro atualizado com sucesso!</span>";
            echo '<a href="./"><button class="cornerButton ">Voltar</button></a>'; 
            exit();
        }else{
            print "<span class='colorRed'>Erro ao atualizar registro</span>";
            echo '<a href="./"><button class="cornerButton ">Voltar</button></a>';  
            exit();
        }
    }

    function imprimeContacts($connection){
        $sql = "select * from contact order by data DESC";
        mysqli_query($connection, $sql);
        $result = mysqli_query($connection, $sql);
        date_default_timezone_set("America/Sao_Paulo");
        while($row = mysqli_fetch_assoc($result)){
            echo "<div class='borderRadius padding2 backgroundWhite'>
                    <div><b>Informação:</b>".$row['info']."</div><br>
                    <div><b>Contato:</b>".$row['contact']."</div><br>
                    <div><b>Data/hora:</b>".date("d/m/Y H:i:s ",$row['data'])."</div></div><br><br>";
        }
    }
?>
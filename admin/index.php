<?php
    require_once "../connection.php";
    session_start();
    if(isset($_SESSION['userid'])){
        header("Location:./internal.php");
    }
    if(isset($_POST['user'], $_POST['password'])){
        $user = mysqli_real_escape_string($connection, $_POST['user']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $sql = "SELECT id,user,password FROM users WHERE user = '$user'";
        $result = mysqli_query($connection, $sql);
        //verifica usuário
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_array($result);
            //verifica a senha
            if (password_verify($password, $row['password'])) {
                $_SESSION['userid'] = $row['id'];
                header("Location:./internal.php");
            }else{
                print "<span class='colorRed bold''>Senha incorreta</span>";
            }
        }else{ 
            print "<span class='colorRed bold'>Usuário incorreto</span>";
        }
    }
    
?>
<head>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<div class="padding2">
    <form method="POST" action="../admin/">
        <label for="user">Usuário: </label><br>
        <input type="text" name="user"><br>
        <label for="password">Senha: </label><br>
        <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
</div>


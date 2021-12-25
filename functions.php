<?php

    function paginamanutencao($Logo){
        if(strpos($_SERVER['REQUEST_URI'], "admin") === false){
            echo "
            <div class='center'>
                <img style='max-height:500px;' src='./icon/".$Logo."'><br>
                <p class='msg magin2 bigFont bold' class='center'>Página em manutenção</p>
            </div>";
            Die();
        }
    }
    
    //GRAVA O ENDEREÇO DE IP, DATA E QUAL MENSAGEM FOI VIZUALIZADA PELO USUÁRIO
    //PARA ORGANIZAR AS MENSAGENS MAIS VISTAS NO FEED
    function get_client_ip($connection){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        }else if(isset($_SERVER['REMOTE_ADDR'])){
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }else{
            $ipaddress = 'UNKNOWN';
        }

        $ipaddress = mysqli_real_escape_string($connection, $ipaddress);
        
        date_default_timezone_set("America/Sao_Paulo");
        $data = mysqli_real_escape_string($connection, time());
        if(isset($_GET['id'])){
            $id = mysqli_real_escape_string($connection, $_GET['id']);
            $sql = "insert into visualizacoes (id_mensagem, ip, data) values ('$id', '$ipaddress', '$data')";
        }else{
            $sql = "insert into visualizacoes (id_mensagem, ip, data) values (null, '$ipaddress', '$data')";
        }
        mysqli_query($connection, $sql);
        $affected_row = mysqli_affected_rows($connection);
        /*if($affected_row == 1){
            print "<span class='colorGreen'>Registro efetuado com sucesso!</span>";
        }else{
            print "<span class='colorRed'>Erro ao inserir registro</span>";
        }*/
    }

    //GRAVA AS INFORMAÇÕES DO FORMULARIO DE CONTATO
    function insertContact($connection){
        $info = mysqli_real_escape_string($connection, htmlspecialchars($_POST['info']));
        $contact = mysqli_real_escape_string($connection, htmlspecialchars($_POST['contact']));
        date_default_timezone_set("America/Sao_Paulo");
        $data = mysqli_real_escape_string($connection, time());
        $sql = "insert into contact (info, contact, data) values ('$info','$contact','$data')";
        mysqli_query($connection, $sql);
        $affected_row = mysqli_affected_rows($connection);
        if($affected_row == 1){
            print "<script>alert('Registro efetuado com sucesso!, entraremos em contato em breve!');</script>";
        }else{
            print "<script>alert('Erro ao inserir registro');</script>";
        }
        
    }

?>
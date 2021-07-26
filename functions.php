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

    //Define uma cor inversa a cor1 para que o resultado seja legivel mesmo se a imagem de fundo não carregar
    function color_inverse($color){
        $color = str_replace('#', '', $color);
        if (strlen($color) != 6){ return '000000'; }
        $rgb = '';
        for ($x=0;$x<3;$x++){
            $c = 255 - hexdec(substr($color,(2*$x),2));
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }
        return '#'.$rgb;
    }
    
    //Imprime o resultado tanto quando o usuário faz pesquisa ou entra na pagina inicial
    function imprimeResultado($result, $ad){
        //IMPRESSÃO DOS RESULTADOS
        $impressos = 0;
        while($row = mysqli_fetch_assoc($result)){
            $url = $_SERVER['HTTP_HOST']."/mensagem.php?id=".$row['id']."&titulo=".urlencode($row['titulo']);
            $href = "./mensagem.php?id=".$row['id']."&titulo=".urlencode($row['titulo']);
            echo "
                <article class='bigFont bold borderRadius round' data-style='color:".$row['cor1'].";background-color:".color_inverse($row['cor1']).";background-image: url(/imgbg/".$row['imgbg'].");'>
                    <div class='padding2 roundmask borderRadius mask'>
                        <a href='$href'>
                        <header>
                        <h2 class='margin0 firstHalfRound halfRound inlineBlock bigFont' style='color:".$row['cor1']."'>".$row['titulo']."</h2>
                        ";
                        if($row['img'] != ""){
                        echo "<div class='secondHalfRound halfRound float'>
                            <img data-src='/img/".$row['img']."' alt='".$row['titulo']."' class='resultIcon height100 float'>
                        </div>";
                        }
                        echo "</header>
                        <p class='msg magin2 bigFont bold' style='color:".$row['cor1'].";'>".$row['texto']."</p>
                        </a>";
                        if(strpos($_SERVER['REQUEST_URI'], "admin") === false){
                            echo"<div>
                        <a href='".geraWhats($url)."'><div class='smallShareButton padding10 inlineBlock borderRadius whatsColor'><img data-src='/icon/whats.webp' alt='WhatsApp' class='height100'></div></a>
                        <a href='". geraFace($url)."'><div class='smallShareButton padding10 inlineBlock borderRadius faceColor'><img data-src='/icon/face.webp' alt='Facebook' class='height100'></div></a>
                        <div class='smallShareButton padding10 inlineBlock borderRadius backgroundWhite' onclick='".geraLink($url, $row['titulo'])."'><img data-src='/icon/link.webp' alt='Outras redes' class='height100'></div>
                        </div>";
                        }

                        echo"   <span class='counter float'></span>
                    </div>
                </article>";
                $impressos++;
            if($ad != "" && $impressos == 5){
                $impressos = 0;
                echo "<br><div class='center'>".$ad."</div><br>";
            }
        }
    }

    function getAd(){
        require "./connection.php";
        $sql = "select ad from conf";
        $ad = mysqli_query($connection, $sql);
        $ad = mysqli_fetch_array($ad);
        $ad = $ad['ad'];
        return $ad;
    }

    //FUNÇÕES REPONSÁVEIS PELOS BOTÕES DE COMPARTILHAMENTO
    function verificaMobile(){
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
            return true;
        }else{
            return false;
        }
    }

    function geraWhats($url){
        if (verificaMobile() == true){
            return 'whatsapp://send?text=Dê uma olhada nisso!!!%0A👇👇👇👇%0A '.urlencode($url);
        }else{
            return 'https://api.whatsapp.com/send?text=Dê uma olhada nisso!!!%0A👇👇👇👇%0A '.urlencode($url);
        }
    }

    function geraFace($url){
        return 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($url);
    }

    function geraLink($url, $titulo){   
        if(verificaMobile() == true){
            return 'navigator.share({title:"'.$_SERVER['HTTP_HOST'].'", text:"'.$titulo.'", url:"'.$url.'"});';
        }else{
            return 'navigator.clipboard.writeText("'.$url.'"); alert("Link copiado para area de transferência!!!"); location.href = "//'.$url.'";';
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
<?php
    require_once "header.php";
    
    //VERIFICA SE O FORMULARIO FOI ENVIADO
    if(isset($_POST['info']) && isset($_POST['contact'])){
        require_once "connection.php";
        require_once "functions.php";
        insertContact($connection);
    }
?>
<div class="msg padding2">
    <form method="post">
        <label for="info">Informação:</label>
        <textarea id="info" class="formCadastro width100" placeholder="Deixe sua mensagem, dúvida ou reclamação aqui..." name="info" required></textarea>
        <label for="contact">Informação para contato:</label>
        <input id="contact" class="formCadastro width100" type="text" name="contact" required>
        <input type="submit">
    </form>
    <br>
    <span>Após o envio entraremos em contato o mais rápido possível!!</span>
</div>
<?php
    require_once "footer.php";
?>
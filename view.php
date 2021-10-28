<?php
    require_once "header.php";
?>
<article style="background-color: <?php print $inversocor1; ?>;
    background-image: url(<?php print $imgbg; ?>);
    background-size: cover;
    background-attachment: fixed;">
    <div class="mask center">
        <br>
        <?php
            echo "<h1 class='msg magin2 bigFont bold' style='color: $cor2'>$titulo</h1>";
        ?>
        <br>
        <?php if($img != "../img/"){echo '<img class="mainImg" data-src="'.$img.'" alt="'.$titulo.'">';}?>
        <br>
        <?php 
            if($ad != ""){
                echo "<br><div class='center'>".$ad."</div><br>";
            }
        ?>
        <br>
        <p class="msg magin2 bigFont bold" style="color: <?php print $cor1; ?>;"><?php print $texto; ?></p>
        <br>
        <div>
            <?php $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
            <a href="<?php echo geraWhats($url) ?>"><div class="bigShareButton borderRadius smallFont inlineBlock whatsColor"><img data-src="/icon/whats.webp" alt="WhatsApp" class="bigShareButtonIcon"><br>WhatsApp</div></a>
            <a href="<?php echo geraFace($url) ?>"><div class="bigShareButton borderRadius smallFont inlineBlock faceColor"><img data-src="/icon/face.webp" alt="Facebook" class="bigShareButtonIcon"><br>Facebook</div></a>
            <div class="bigShareButton borderRadius smallFont inlineBlock backgroundWhite" onclick='<?php echo geraLink($url, $titulo); ?>'><img data-src="/icon/link.webp" alt="Outras redes" class="bigShareButtonIcon"><br>Link</div>
        </div>
        <div>
            <p class="msg magin2 bigFont bold" style="color: <?php print $cor1; ?>;"> Veja mais em: <a  href="/" style="color: <?php print $cor2; ?>;"><?php echo $_SERVER['HTTP_HOST']; ?></a></p><br>
        </div>
    </div>
</article>
<?php
    require_once "footer.php";
?>
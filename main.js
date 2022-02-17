//LAZY-LOAD IMAGENS
ativaNoScroll();
window.addEventListener('scroll', ativaNoScroll);
function ativaNoScroll() {  
    document.querySelectorAll('img').forEach((img, index) => {
        if(img.getBoundingClientRect().top < window.innerHeight+5000 && img.getBoundingClientRect().top > -5000) {
            img.src = img.getAttribute('data-src');
        }
    })
    
    var round = document.getElementsByClassName('round')
    for(var i = 0; i < round.length; i++){
        if(round[i].getBoundingClientRect().top < window.innerHeight+5000 && round[i].getBoundingClientRect().top > -5000) {
            round[i].style = round[i].getAttribute('data-style');
        }
    }
}

//VERIFICA SE O USÚARIO ACEITOU TERMOS
if(getCookie("aceite") === "true" && window.location.href.indexOf("/admin") == -1){
    aceite.style = "display: none;"
}
//REGISTRA ACEITE DOS TERMOS
document.onclick = function(){
    setCookie("aceite", "true", 365);
    aceite.style = "display: none;"
}
//RETORNA O VALOR DE COOKIE 
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return "";
}
//REGISTRA COOKIE
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


//VERIFICA SE O USÁRIO ESTÁ NA PÁGINA PRINCIPAL
var feed = document.getElementById("feed");
if (feed != null) {
    var feedIndex = 0;
    var waitingResponse;
    const params = new URLSearchParams(window.location.search);
    if (params.get("search") != null ) {
        requestSearch(params.get("search"));
    } else {
        requestFeed();
    }
    window.addEventListener("scroll", () => {
        if (isItEnding() === true && waitingResponse === false) {
            requestFeed();
        }
    });
}else{
    if(row.cor1 != undefined && (window.location.href.indexOf("/mensagem.php") != -1) || window.location.href.indexOf("/preview.php") != -1){
        buildArticle();
    }
}

async function requestSearch(search){
    waitingResponse = true;
    let req = await fetch("/search.php",  {method: "POST", headers: {'Content-Type': 'application/json;charset=utf-8'}, body: search });
    let res = await req.text();
    if(res == ""){
        feed.innerHTML = feed.innerHTML + '<br><span class="padding2">Nenhum resultado encontrado para "'+search+'"</span><br><br>';
    }else{
        res = JSON.parse(res);
        feed.innerHTML = feed.innerHTML + '<br><span class="padding2">'+res.length+' resultado(s) encontrados para "'+search+'"</span><br><br>'
        buildFeed(res);
    }
    requestFeed();
}

async function requestFeed(){
    waitingResponse = true;
    let req = await fetch("/feed.php",  {method: "POST", headers: {'Content-Type': 'application/json;charset=utf-8'}, body: feedIndex});
    let res = await req.text();
    if(feedIndex == 0){
        feed.innerHTML = feed.innerHTML + '<br><span class="padding2">Destaques da última semana.</span><br><br>';
    }
    if(res != ""){
        buildFeed(JSON.parse(res));
        feedIndex++;
        waitingResponse = false;
    }
}

function buildFeed(res) {
    if (window.location.href.indexOf("/admin") == -1) {
        feed.innerHTML = feed.innerHTML + "<div style='text-align: center'>" + ad + "</div>";
    }
    let codeHTML = "";
    for (let article of res) {
        let url =
            "https://" + window.location.hostname + "/mensagem.php?id=" + article.id + "&titulo=" + article.titulo;
        let href = "./mensagem.php?id=" + article.id + "&titulo=" + encodeURI(article.titulo);
        let color_inverse = color_inversor(article.cor1);
        let whats = geraWhats(url);
        let face = geraFace(url);
        let link = geraLink(url, article.titulo);      
        codeHTML += `<article class="bigFont bold borderRadius round" data-style="color:${article.cor1};background-color:${color_inverse};background-image: url(/imgbg/${article.imgbg});">
                <div class="padding2 roundmask borderRadius mask">
                    <a href="${href}">
                        <header>
                            <h2 class="margin0 firstHalfRound halfRound inlineBlock bigFont" style="color:${article.cor1}">${article.titulo}</h2>`;
        if (article.img != "") {
            codeHTML += `<div class="secondHalfRound halfRound float">
                    <img data-src="/img/${article.img}" alt="${article.titulo}" class="resultIcon height100 float">
                </div>`;
        }
        codeHTML += `</header>
                <p class="msg magin2 bigFont bold" style="color:${article.cor1};">
                    ${article.texto}
                </p>
            </a>`;
        if (window.location.href.indexOf("/admin") == -1) {
            codeHTML += `<div>
                    <a href="${whats}">
                        <div class="smallShareButton padding10 inlineBlock borderRadius whatsColor">
                            <img data-src="/icon/whats.webp" alt="WhatsApp" class="height100">
                        </div>
                    </a>
                    <a href="${face}">
                        <div class="smallShareButton padding10 inlineBlock borderRadius faceColor">
                            <img data-src="/icon/face.webp" alt="Facebook" class="height100">
                        </div>
                    </a>
                    <div class="smallShareButton padding10 inlineBlock borderRadius backgroundWhite" onclick='${link}'>
                        <img data-src="/icon/link.webp" alt="Outras redes" class="height100">
                    </div>
                </div>`;
        }
        codeHTML += "<span class='counter float'></span></div></article>";  
    }
    feed.innerHTML = feed.innerHTML + codeHTML;
    ativaNoScroll();
    if (ad != "" && window.location.href.indexOf("/admin") == -1) {
        (adsbygoogle = window.adsbygoogle || []).push({});
    }
}

function buildArticle() {
    let color_inverse = color_inversor(row.cor1);
    let url = window.location.href;
    let article = document.getElementsByTagName("article")[0];
    article.style.backgroundColor = color_inverse;
    article.style.backgroundImage = "url(/imgbg/" + row.imgbg + ")";
    article.style.backgroundSize = "cover";
    article.style.backgroundAttachment = "fixed";
    let codeHTML = `<div class="mask center">
            <br>
            <h1 class="msg magin2 bigFont bold" style="color:${row.cor2}">${row.titulo}</h1>
            <br>`;
    if (article.img != "") {
        codeHTML += `<img class="mainImg" data-src="/img/${row.img}" alt="${row.titulo}">`;
    }
    codeHTML += `<br>`;
    if (ad != "" && window.location.href.indexOf("/admin") == -1) {
        codeHTML += `<br><div class='center'>${ad}</div><br>`;
    }
    codeHTML += `<br>
            <p class="msg magin2 bigFont bold" style="color:${row.cor1};">${row.texto}</p>
        <br>`;
    if (window.location.href.indexOf("/admin") == -1) {
        codeHTML += `<div>
            <a id="whats" href="${geraWhats(
                url
            )}"><div class="bigShareButton borderRadius smallFont inlineBlock whatsColor"><img data-src="/icon/whats.webp" alt="WhatsApp" class="bigShareButtonIcon"><br>WhatsApp</div></a>
            <a id="face" href="${geraFace(
                url
            )}"> <div class="bigShareButton borderRadius smallFont inlineBlock faceColor"><img data-src="/icon/face.webp" alt="Facebook" class="bigShareButtonIcon"><br>Facebook</div></a>
            <div id='link' class='bigShareButton borderRadius smallFont inlineBlock backgroundWhite' onclick='${geraLink(
                url,
                row.titulo
            )}'><img data-src='/icon/link.webp' alt='Outras redes' class='bigShareButtonIcon'><br>Link</div>
        </div>
        <div>
            <p class="msg magin2 bigFont bold" style="color:${
                row.cor1
            };">Veja mais em: <a  href="/" style="color:${row.cor2};">${window.location.hostname}</a></p><br></div>
        </div>`;
    }
    article.innerHTML = codeHTML;
    ativaNoScroll();
    if (ad != "" && window.location.href.indexOf("/admin") == -1) {
        (adsbygoogle = window.adsbygoogle || []).push({});
    }
}

function color_inversor(color){
    color = color.replace('#', '');
    if (color.length != 6){ return '000000'; }
    let rgb = '';
    for (x=0; x<3; x++){
        c = 255 - parseInt(color.substr(x*2, 2), 16);
        c = (c < 0) ? 0 : (c).toString(16);
        rgb = ((c.length < 2) ? "00" : c) + rgb;
    }
    return '#'+rgb;
}

function isItEnding(){
    var articles = document.getElementsByClassName('round')
    if(articles.length != 0 ){
        var lastArticle = articles[articles.length-1];
        if(lastArticle.getBoundingClientRect().bottom < 10000){       
            return true;
        }else{
            return false;
        }
    }
}

//FUNÇÕES REPONSÁVEIS PELOS BOTÕES DE COMPARTILHAMENTO
function mobileCheck () {
    let check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
}

function geraWhats(url){
    if (mobileCheck() == true){
        return 'whatsapp://send?text=Dê uma olhada nisso!!!%0A👇👇👇👇%0A '+encodeURI(url);
    }else{
        return 'https://api.whatsapp.com/send?text=Dê uma olhada nisso!!!%0A👇👇👇👇%0A '+encodeURI(url);
    }
}

function geraFace(url){
    return 'https://www.facebook.com/sharer/sharer.php?u='+encodeURI(url);
}

function geraLink(url, titulo){   
    if(mobileCheck() == true){
        return 'navigator.share({title:"'+window.location.hostname+'", text:"'+titulo+'", url:"'+url+'"});';
    }else{
        return 'navigator.clipboard.writeText("'+url+'"); alert("Link copiado para area de transferência!!!"); location.href = "'+url+'";';
    }
}

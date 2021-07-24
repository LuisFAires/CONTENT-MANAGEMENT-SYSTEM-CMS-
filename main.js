//VARIÁVEIS PARA LAZY-LOAD DO FEED
var mensagemI = -1;
var lastSent = -1;
var anunciosImpressos = 0;

//VERIFICA SE O USÁRIO ESTÁ NA PÁGINA PRINCIPAL
var principal = document.getElementById("principal");
if(principal != null){
    verificaSearch()
}


//LAZY-LOAD IMAGENS
ativaNoScroll()
window.addEventListener('scroll', ativaNoScroll);

//LAZY-LOAD FEED
var scrollInterval = setInterval(lazyFeed, 2500);

//VERIFICA SE O USÚARIO ACEITOU TERMOS
if(getCookie("aceite") === "true"){
    aceite.style = "display: none;"
}


//REGISTRA ACEITE DOS TERMOS
document.onclick = function(){
    setCookie("aceite", "true", 365);
    aceite.style = "display: none;"
}

function lazyFeed(){
    if(isItEnding() == true){
        imprimeMensagem();
    }
}

function isItEnding(){
    var articles = document.getElementsByClassName('round')
    if(articles.length != 0 ){
        var lastArticle = articles[articles.length-1];
        if(lastArticle.getBoundingClientRect().bottom < 5000){       
            return true;
        }else{
            return false;
        }
    }
}

//Verifica se há algum parâmetro para pesquisa, se sim realiza a pesquisa, após carrega o feed com as demais mensagens.
async function verificaSearch(){
    const params = new URLSearchParams(window.location.search)
    if(params.get('search') != null){
        let pede = await fetch("/search.php",  {method: "POST", headers: {'Content-Type': 'application/json;charset=utf-8'}, body: params.get('search')});
        let recebido = await pede.text();
        principal.innerHTML = recebido + principal.innerHTML;         
        ativaNoScroll();
        imprimeMensagem();
    }else{
        imprimeMensagem();
    }
}

//CARREGA O FEED CONFORME O SCROLL DO USÚARIO
async function imprimeMensagem(){
    
    clearInterval(scrollInterval);

    //Corrige o valor da variavel mensagemI quando o servidor demora para responder e o valor é incrementado de forma desnecessária
    if(mensagemI > lastSent+1){
        mensagemI = lastSent+1;
        return;
    }

    lastSent = mensagemI
    mensagemI++;
    fetch("/feed.php",  {method: "POST", headers: {'Content-Type': 'application/json;charset=utf-8'}, body: mensagemI}).then(function(response) {
        response.text()
        .then(function(result) {
            if(result == ""){
                return;
            }else{
                
                principal.innerHTML = principal.innerHTML + result;
                ativaNoScroll();
        
                var anuncios = document.getElementsByClassName("adsbygoogle").length;
                while(anuncios-1 > anunciosImpressos){
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    anunciosImpressos++;
                }
                
                scrollInterval = setInterval(lazyFeed, 2500);
            
            }
        })
    })    
}

//CARREGA IMAGENS CONFORME SCROLL DO USÚARIO
function ativaNoScroll() {
    
    document.querySelectorAll('img').forEach((img, index) => {
        if(img.getBoundingClientRect().top < window.innerHeight+3000 && img.getBoundingClientRect().top > -3000) {
            img.src = img.getAttribute('data-src');
        };		
    })
    
    var round = document.getElementsByClassName('round')
    for(var i = 0; i < round.length; i++){
        if(round[i].getBoundingClientRect().top < window.innerHeight+3000 && round[i].getBoundingClientRect().top > -3000) {
            round[i].style = round[i].getAttribute('data-style');
        };		
    }
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
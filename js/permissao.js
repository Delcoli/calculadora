/***********************************************************************
 Verifica se o usuário está logado
 **********************************************************************/

function getCookie(id) {
    var listaCookie = document.cookie.split(';');
    var cookie = null;

    for(var i=0; i<listaCookie.length; i++) {
        cookie = listaCookie[i].split('=');
        if (cookie[0] == id) {
            return cookie[1];
        };
    }

    return null;
}

function logado() {
    if (getCookie('logado') == null || getCookie('logado') == 'null') {
        window.location = "login.html";
    }
    return null;
}

function logout() {
    document.cookie = "logado=null";
}


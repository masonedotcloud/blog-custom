/*
    login.js
    passaggio elementi per il login
*/
//al caricamento della pagina
$(document).ready(function () {
    //click sul tasto login
    $("#form-login").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        //controllo se è presente nel passaggio di parametri un url a cui riportare dopo il login
        var redirect = null;
        var parameter = 'redirect';
        var url = window.location.href;
        if ((url.indexOf('?' + parameter + '=') != -1) || (url.indexOf('&' + parameter + '=') != -1)) { //controllo del parametro
            var url_string = window.location.href;
            var url = new URL(url_string);
            redirect = url.searchParams.get('redirect');
        }
        $.ajax({
            type: 'POST',
            url: 'statics/php/login.php?login',
            data: formData,
            success: function (data) {
                debug(data);
                if (data == 'login-success') { //in caso di successo del login porta alla index o al redirect presente
                    if (redirect != null) { window.location.href = redirect; }
                    else { window.location.href = "index"; }
                } else { //errore nel login
                    var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
                    $.post(url,
                        function (data) {
                            debug(data);
                            document.getElementById("info").innerHTML = data;
                            setTimeout(function () {
                                document.getElementById("info").innerHTML = "";
                            }, 2500);
                        }
                    );
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    //logo grande del login
    logo("big-logo");
});



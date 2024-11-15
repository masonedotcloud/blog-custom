/*
    password.js
    gestione chiamate per modificare la password dimenticata
*/
//al caricamento della pagina
$(document).ready(function () {
    //click sull'invio dell'email per la richiesta di reset password
    $("#form-email").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/password.php?email',
            data: formData,
            success: function (data) {
                debug(data);
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
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    //click sul cambio password
    $("#data-password").submit(function (e) {
        e.preventDefault();
        var url_string = window.location.href;
        var url = new URL(url_string);
        var otp = url.searchParams.get("otp");
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/password.php?otp=' + otp,
            data: formData,
            success: function (data) {
                debug(data);
                if (data == 'reset-success') {
                    window.location.href = "login";
                } else {
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
    //controllo password live
    check_password_bar();
});




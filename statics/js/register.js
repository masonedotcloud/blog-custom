/*
    register.js
    registrazione utente
*/
//al caricamento della pagina
$(document).ready(function () {
    //dati del form di registrazione
    $("#form-register").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/register.php?add',
            data: formData,
            success: function (data) {
                debug(data);
                if (data == 'register-success') { //reigstrazione eseguita con successo
                    window.location.href = "code";
                } else { //errore durante la registrazione
                    //alert a video
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
    //cambio dinamico dell'immagine nella mini preview
    avatar.onchange = evt => {
        const [file] = avatar.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
    //controllo password live
    check_password_bar();
    //logo grande
    logo("big-logo");
});



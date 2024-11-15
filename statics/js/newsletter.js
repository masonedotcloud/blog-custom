/*
    newsletter.js
    aggiunta di un utente alla newsletter
*/
//al caricamento della pagina
$(document).ready(function () {
    //iscrizione alla newsletter
    $("#form-newsletter").submit(function (e) {
        e.preventDefault();
        const email = document.querySelector('#email').value;
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/newsletter.php?add',
            data: formData,
            success: function (data) {
                debug(data);
                if (data == "success") {
                    var div = '<div class="alert alert-success" role="alert">' + email + '<br>iscrizione avvetura con successo</div>';
                    document.getElementById('newsletter').innerHTML = div;
                } else {
                    var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
                    $.post(url,
                        function (data) {
                            debug(data);
                            document.getElementById("info-newsletter").innerHTML = data;
                            setTimeout(function () {
                                document.getElementById("info-newsletter").innerHTML = "";
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
});

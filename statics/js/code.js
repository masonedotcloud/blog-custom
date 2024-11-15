/*
    code.js
    Chiamate a codice php per il controllo del codice
*/
//al caricamento della pagina
$(document).ready(function () {
    //click sul bottone conferma email con il codice
    $("#code-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/code.php?check',
            data: formData,
            success: function (data) {
                debug(data);
                if (data == 'code-success') {
                    window.location.href = "index";
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
    //logo grande
    logo("big-logo");
});

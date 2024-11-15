/*
    navbar.js
    fill navbar
*/
//funzione per la richiesta delle caratteristiche base della navbar
function navbar_element() {
    $.ajax({
        url: 'statics/php/site.php?name',
        success: function (response) {
            debug(response);
            if (document.getElementById("user_name") && document.getElementById("user_name").innerHTML != response) {
                document.getElementById("user_name").innerHTML = response;
            }
        }
    });
    $.ajax({
        url: 'statics/php/site.php?logo',
        success: function (response) {
            debug(response);
            if (document.getElementById("setting_site_logo") && document.getElementById("setting_site_logo").src != response) {
                document.getElementById("setting_site_logo").src = response;
            }
        }
    });
    $.ajax({
        url: 'statics/php/site.php?avatar',
        success: function (response) {
            debug(response);
            if (document.getElementById("user_avatar") && document.getElementById("user_avatar").src != response) {
                document.getElementById("user_avatar").src = response;
            }
        }
    });
    $.ajax({
        url: 'statics/php/site.php?phrases',
        success: function (response) {
            debug(response);
            if (document.getElementById("phrases-effect") && document.getElementById("phrases-effect").innerHTML != response) {
                document.getElementById("phrases-effect").innerHTML = response;
            }
        }
    });

    
}
//al caricamento della pagina
$(document).ready(function () {
    navbar_element();
});
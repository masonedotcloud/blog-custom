/*
    header.js
    rimpimento dell'header
*/
//favicon del sito
function header_element() {
    $.ajax({
        url: 'statics/php/site.php?logo',
        success: function (response) {
            const linkElement = document.querySelector('link[rel=icon]');
            if (linkElement.href != response) {
                linkElement.href = response;
            }
        }
    });
}
//al caricamento della pagina
$(document).ready(function () {
    header_element();
});
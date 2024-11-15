/*
    post.js
    visualizzazione del post singolo con le varie sidebar
*/
var number_random_post = 5;
//eliminazione di un preferito
function delete_favorite(id, info) {
    var url = "statics/php/profile.php?favorites_delete=" + id;
    $.post(url,
        function (data) {
            console.log(data);
            debug(data);
            var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
            $.post(url,
                function (data) {
                    debug(data);
                    document.getElementById(info).innerHTML = data;
                    setTimeout(function () {
                        document.getElementById(info).innerHTML = "";
                    }, 2500);
                }
            );
            if (data.includes("&type=success")) {
                document.getElementById("favorite-" + id).innerHTML = '<button id="favorite-' + id + '" onclick="add_favorite(' + id + ', \'info\')" type="button" class="btn btn-warning"><i class="bi bi-star-fill"></i> Aggiungi ai preferiti</button>';
            }
        }
    );
}
//aggiunta di un preferito
function add_favorite(id, info) {
    var url = "statics/php/profile.php?favorites_add=" + id;
    $.post(url,
        function (data) {
            console.log(data);
            debug(data);
            var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
            $.post(url,
                function (data) {
                    debug(data);
                    document.getElementById(info).innerHTML = data;
                    setTimeout(function () {
                        document.getElementById(info).innerHTML = "";
                    }, 2500);
                }
            );
            if (data.includes("&type=success")) {
                document.getElementById("favorite-" + id).innerHTML = ' <button id="favorite-' + id + '" onclick="delete_favorite(' + id + ', \'info\')" type="button" class="btn btn-warning"><i class="bi bi-star-fill"></i> Rimuovi dai preferiti</button>';
            }
        }
    );
}
//al caricamento della pagina
$(document).ready(function () {
    //chiamata per gli articoli casuali
    $.ajax({
        url: "statics/php/post.php?insert_content_random&number=" + number_random_post,
        success: function (data) {
            console.log(data);
            $('#insert-content-random').html(data);
        }
    });
});
/*
    index.js
    analisi dei parametri e visualizzazione delle preferenze / categorie / posts
*/
//caricamento del contenuto da far visualizzare
function load_data(page, query = '', category = '') {
    $.ajax({
        url: "/alessandromasone.altervista.org/statics/php/site.php?search",
        method: "POST",
        data: {
            page: page,
            query: query,
            category: category,
        },
        success: function (data) {
            $('#insert-content').html(data);
        }
    });
    masonryUpdate();
}
//visualizzazione della lista delle categorie
function view_category(id = 'view_category_list') {
    if (id == 'view_category_list') {
        load_data(1, '', 'view_category_list');
    } else {
        load_data(1, '', id);
    }
    document.getElementById('search_box').value = '';
    var url = window.location.href;
    var text = '/alessandromasone.altervista.org';
    if (id != '') {
        if (text.includes('?')) {
            text += '&category=' + id;
        } else {
            text += '?category=' + id;
        }
    }
    history.pushState({}, null, text);
}
//visualizzazione della list dei post
function view_posts() {
    load_data(1);
    document.getElementById('search_box').value = '';
    history.pushState({}, null, '/alessandromasone.altervista.org');
}
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
                document.getElementById("favorite-" + id).remove()
            }
        }
    );
}
//al caricamento della pagina
$(document).ready(function () {
    //controllo del popup per il login/sessione
    $.ajax({
        url: 'statics/php/site.php?popup',
        success: function (response) {
            debug(response);
            if (response != 'null') {
                var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + response;
                $.post(url,
                    function (response) {
                        debug(response);
                        document.getElementById("info").innerHTML = response;
                        setTimeout(function () {
                            document.getElementById("info").innerHTML = "";
                        }, 7500);
                    }
                );
            }
        }
    });
    //controllo popup per le reigstrazioni
    $.ajax({
        url: 'statics/php/site.php?popup2',
        success: function (response) {
            debug(response);
            if (response != 'null') {
                var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + response;
                $.post(url,
                    function (response) {
                        debug(response);
                        $("#info").append(response);
                        setTimeout(function () {
                            document.getElementById("info").innerHTML = "";
                        }, 7500);
                    }
                );
            }
        }
    });
    //riempimento con i parametri dell'url
    var url = window.location.href;
    var text = '/alessandromasone.altervista.org';
    var query = '';
    var page = 1;
    var category = '';
    //paramtro di ricerca
    var parameter = 's';
    if ((url.indexOf('?' + parameter + '=') != -1) || (url.indexOf('&' + parameter + '=') != -1)) {
        var url_string = window.location.href;
        var url_temp = new URL(url_string);
        query = url_temp.searchParams.get(parameter);
        document.getElementById("search_box").value = query;
        if (query.length > 0 && text.includes('?')) {
            text += '&s=' + encodeURIComponent(query);
        } else if (query.length > 0 && !(text.includes('?'))) {
            text += '?s=' + encodeURIComponent(query);
        }
    }
    //paramtro della pagina
    parameter = 'page';
    if ((url.indexOf('?' + parameter + '=') != -1) || (url.indexOf('&' + parameter + '=') != -1)) {
        var url_string = window.location.href;
        var url_temp = new URL(url_string);
        page = url_temp.searchParams.get(parameter);
        if (text.includes('?')) {
            text += '&page=' + page;
        } else {
            text += '?page=' + page;
        }
    }
    //paramtro della categoria
    parameter = 'category';
    if ((url.indexOf('?' + parameter + '=') != -1) || (url.indexOf('&' + parameter + '=') != -1)) {
        var url_string = window.location.href;
        var url_temp = new URL(url_string);
        category = url_temp.searchParams.get(parameter);
        if (text.includes('?')) {
            text += '&category=' + category;
        } else {
            text += '?category=' + category;
        }
    };
    history.pushState({}, null, text);
    load_data(page, query, category);
});
//input sulla barra di ricerca
$('#search_box').keyup(function () {
    var query = $('#search_box').val();
    text = '';
    if (query.length > 0 && text.includes('?')) {
        text += '&s=' + encodeURIComponent(query);
    } else if (query.length > 0 && !(text.includes('?'))) {
        text += '?s=' + encodeURIComponent(query);
    }
    var url = window.location.href;
    var category = '';
    //modifica parametro dell'url
    parameter = 'category';
    if ((url.indexOf('?' + parameter + '=') != -1) || (url.indexOf('&' + parameter + '=') != -1)) { //controllo del parametro
        var url_string = window.location.href;
        var url_temp = new URL(url_string);
        category = url_temp.searchParams.get(parameter);
        if (category != '') {
            if (text.includes('?')) {
                text += '&category=' + category;
            } else {
                text += '?category=' + category;
            }
        }
    }
    if (text == '') {
        text = '/';
    }
    history.pushState({}, null, text);
    load_data(1, query, category);
});
//click su pagina avanti e pagina indietro
$(document).on('click', '.page-link', function () {
    var url = window.location.href;
    var text = '/alessandromasone.altervista.org';
    var query = '';
    var page = 1;
    var category = '';
    //paramtro della ricerca
    var parameter = 's';
    if ((url.indexOf('?' + parameter + '=') != -1) || (url.indexOf('&' + parameter + '=') != -1)) {
        var url_string = window.location.href;
        var url_temp = new URL(url_string);
        query = decodeURIComponent(url_temp.searchParams.get(parameter));
        document.getElementById("search_box").value = query;
        if (query.length > 0 && text.includes('?')) {
            text += '&s=' + encodeURIComponent(query);
        } else if (query.length > 0 && !(text.includes('?'))) {
            text += '?s=' + encodeURIComponent(query);
        }
    }
    //paramtro della pagina
    parameter = 'page';
    page = $(this).data('page_number');
    if (page > 0 && text.includes('?')) {
        text += '&page=' + page;
    } else if (page > 0) {
        text += '?page=' + page;
    }
    //paramtro della categoria
    parameter = 'category';
    if ((url.indexOf('?' + parameter + '=') != -1) || (url.indexOf('&' + parameter + '=') != -1)) { //controllo del parametro
        var url_string = window.location.href;
        var url_temp = new URL(url_string);
        category = url_temp.searchParams.get(parameter);
        if (category != '') {
            if (text.includes('?')) {
                text += '&category=' + category;
            } else {
                text += '?category=' + category;
            }
        }
    }
    history.pushState({}, null, text);
    load_data(page, query, category);
});
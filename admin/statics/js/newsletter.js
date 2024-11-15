/*
    newsletter.js
    Gestione delle chiamate per l'inferfaccia utente
*/
//variabile per la pagina attuale e click di invio
var current_page = 1;
var click_for_send = 0;
//controllo delle preferenze al cambiamento e salvataggio
function search_preference(div_name) {
    if (div_name == "order-a-to-z") {
        if (document.getElementById("order-a-to-z").checked) {
            document.getElementById("order-a-to-z").checked = true;
            document.getElementById("order-z-to-a").checked = false;
        } else {
            document.getElementById("order-a-to-z").checked = false;
            document.getElementById("order-z-to-a").checked = true;
        }
    }
    if (div_name == "order-z-to-a") {
        if (document.getElementById("order-z-to-a").checked) {
            document.getElementById("order-z-to-a").checked = true;
            document.getElementById("order-a-to-z").checked = false;
        } else {
            document.getElementById("order-z-to-a").checked = false;
            document.getElementById("order-a-to-z").checked = true;
        }
    }
    var column = document.getElementById("search-for").value;
    if (column == 'domain') {
        document.getElementById('search_box').placeholder = "Ricerca per dominio";
    } else if (column == 'username') {
        document.getElementById('search_box').placeholder = "Ricerca per username";
    } else if (column == 'server') {
        document.getElementById('search_box').placeholder = "Ricerca per server";
    }
    var query = $('#search_box').val();
    load_data(current_page, query);
    setCookie("order-a-to-z_newsletter", document.getElementById("order-a-to-z").checked, 30);
    setCookie("order-z-to-a_newsletter", document.getElementById("order-z-to-a").checked, 30);
    setCookie("search-for_newsletter", document.getElementById("search-for").value, 30);
}
//al caricamento della pagina riempimento delle opzioni di ricerca
function init_search_preference() {
    if (getCookie("order-a-to-z_newsletter") != "" && getCookie("order-a-to-z_newsletter") != "false") {
        document.getElementById("order-a-to-z").checked = true;
    }
    if (getCookie("order-z-to-a_newsletter") != "" && getCookie("order-z-to-a_newsletter") != "false") {
        document.getElementById("order-z-to-a").checked = true;
    }
    if (getCookie("search-for_newsletter") != "") {
        document.getElementById("search-for").value = getCookie("search-for_newsletter");
    }
    if (getCookie("order-a-to-z_newsletter") == '' && getCookie("order-z-to-a_newsletter") == '' && getCookie("search-for_newsletter") == '' && getCookie("search-for_category") == '') {
        document.getElementById("order-a-to-z").checked = true;
        document.getElementById("search-for").value = 'username';
    }
    var column = document.getElementById("search-for").value;
    if (column == 'domain') {
        document.getElementById('search_box').placeholder = "Ricerca per dominio";
    } else if (column == 'username') {
        document.getElementById('search_box').placeholder = "Ricerca per username";
    } else if (column == 'server') {
        document.getElementById('search_box').placeholder = "Ricerca per server";
    }
}
//identificazione delle calusole di ricerca
function load_data(page, query = '') {
    var order = '';
    var column = '';
    //ordinamento
    if (document.getElementById("order-a-to-z").checked) {
        order = 'ASC';
    }
    if (document.getElementById("order-z-to-a").checked) {
        order = 'DESC';
    }
    //colonna di ricerca
    column = document.getElementById("search-for").value;
    $.ajax({
        url: "statics/php/newsletter.php?search",
        method: "POST",
        data: {
            page: page,
            query: query,
            order: order,
            column: column,
        },
        success: function (data) {
            debug(data);
            $('#list-newsletter').html(data);
        }
    });
}
//elimina newsletter
function delete_newsletter(id) {
    var delete_id = id;
    $.ajax({
        url: 'statics/php/newsletter.php?delete=' + delete_id,
        success: function (data) {
            debug(data);
            var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
            $.post(url,
                function (response) {
                    debug(response);
                    if (data.includes("&type=success")) {
                        document.getElementById("info").innerHTML = response;
                        if (document.getElementById('one-card') != null) {
                            if (current_page > 1) {
                                current_page--;
                            }
                        }
                        var query = $('#search_box').val();
                        load_data(current_page, query);
                        setTimeout(function () {
                            document.getElementById("info").innerHTML = "";
                        }, 2500);
                    } else {
                        document.getElementById("info-modal-delete-" + delete_id).innerHTML = response;
                        setTimeout(function () {
                            document.getElementById("info-modal-delete-" + delete_id).innerHTML = "";
                        }, 2500);
                    }
                }
            );
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
//funzione dei due click
function control_two_click() {
    if (document.getElementById("oggetto").value != '' && document.getElementById("content").value != '') {
        click_for_send++;
        document.getElementById("send-email-button").innerHTML = 'Invia (Sei sicuro?) <i class="bi bi-send"></i>';
    }
}
//al caricamento della pagina
$(document).ready(function () {
    init_search_preference();
    load_data(1);
    //cambio pagina
    $(document).on('click', '.page-link', function () {
        var page = $(this).data('page_number');
        current_page = page;
        var query = $('#search_box').val();
        load_data(page, query);
    });
    //ricerca dinamica
    $('#search_box').keyup(function () {
        var query = $('#search_box').val();
        load_data(1, query);
    });
    //invio di un email
    $('#form-send-email').click(function (e) {
        e.preventDefault();
        if (click_for_send == 2) {
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'statics/php/newsletter.php?send',
                data: formData,
                success: function (data) {
                    var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
                    $.post(url,
                        function (data) {
                            debug(data);
                            document.getElementById("info").innerHTML = data;
                            if (data.includes("&type=danger")) {
                                document.getElementById("oggetto").value = "";
                                document.getElementById("content").value = "";
                            }
                            document.getElementById("send-email-button").innerHTML = 'Invia <i class="bi bi-send"></i>';
                            $('#mail-send').modal('hide');
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
            click_for_send = 0;
        }
    });
});







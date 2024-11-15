/*
    users.js
    Gestione delle chiamate per la gestione degli utenti
*/
var current_page = 1;
//controllo delle preferenze al cmabiamento e salvataggio
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
    if (column == 'username') {
        document.getElementById('search_box').placeholder = "Ricerca per username";
    } else if (column == 'name') {
        document.getElementById('search_box').placeholder = "Ricerca per nome";
    } else if (column == 'surname') {
        document.getElementById('search_box').placeholder = "Ricerca per cognome";
    } else if (column == 'email') {
        document.getElementById('search_box').placeholder = "Ricerca per email";
    }
    var query = $('#search_box').val();
    load_data(current_page, query);
    setCookie("order-a-to-z_user", document.getElementById("order-a-to-z").checked, 30);
    setCookie("order-z-to-a_user", document.getElementById("order-z-to-a").checked, 30);
    setCookie("include-active_user", document.getElementById("include-active").checked, 30);
    setCookie("include-disable_user", document.getElementById("include-disable").checked, 30);
    setCookie("include-not-verified_user", document.getElementById("include-not-verified").checked, 30);
    setCookie("include-admin_user", document.getElementById("include-admin").checked, 30);
    setCookie("include-author_user", document.getElementById("include-author").checked, 30);
    setCookie("include-user_user", document.getElementById("include-user").checked, 30);
    setCookie("search-for_user", document.getElementById("search-for").value, 30);
}
//al caricamento della pagina riempimento delle opzioni di ricerca
function init_search_preference() {
    if (getCookie("order-a-to-z_user") != "" && getCookie("order-a-to-z_user") != "false") {
        document.getElementById("order-a-to-z").checked = true;
    }
    if (getCookie("order-z-to-a_user") != "" && getCookie("order-z-to-a_user") != "false") {
        document.getElementById("order-z-to-a").checked = true;
    }
    if (getCookie("include-active_user") != "" && getCookie("include-active_user") != "false") {
        document.getElementById("include-active").checked = true;
    }
    if (getCookie("include-disable_user") != "" && getCookie("include-disable_user") != "false") {
        document.getElementById("include-disable").checked = true;
    }
    if (getCookie("include-not-verified_user") != "" && getCookie("include-not-verified_user") != "false") {
        document.getElementById("include-not-verified").checked = true;
    }
    if (getCookie("include-admin_user") != "" && getCookie("include-admin_user") != "false") {
        document.getElementById("include-admin").checked = true;
    }
    if (getCookie("include-user_user") != "" && getCookie("include-user_user") != "false") {
        document.getElementById("include-user").checked = true;
    }
    if (getCookie("include-author_user") != "" && getCookie("include-author_user") != "false") {
        document.getElementById("include-author").checked = true;
    }
    if (getCookie("search-for_user") != "") {
        document.getElementById("search-for").value = getCookie("search-for_user");
    }
    var column = document.getElementById("search-for").value;
    if (column == 'username') {
        document.getElementById('search_box').placeholder = "Ricerca per username";
    } else if (column == 'name') {
        document.getElementById('search_box').placeholder = "Ricerca per nome";
    } else if (column == 'surname') {
        document.getElementById('search_box').placeholder = "Ricerca per cognome";
    } else if (column == 'email') {
        document.getElementById('search_box').placeholder = "Ricerca per email";
    }
    if (getCookie("order-a-to-z_user") == '' && getCookie("order-z-to-a_user") == '' && getCookie("include-active_user") == '' && getCookie("include-disable_user") == '' && getCookie("include-not-verified_user") == '' && getCookie("include-admin_user") == '' && getCookie("include-user_user") == '' && getCookie("include-author_user") == '' && getCookie("search-for_user") == '') {
        document.getElementById("order-a-to-z").checked = true;
        document.getElementById("include-active").checked = true;
        document.getElementById("include-disable").checked = true;
        document.getElementById("include-not-verified").checked = true;
        document.getElementById("include-admin").checked = true;
        document.getElementById("include-user").checked = true;
        document.getElementById("include-author").checked = true;
        document.getElementById("search-for").value = 'username';
        document.getElementById('search_box').placeholder = "Ricerca per username";
    }
}
//identificazione delle calusole di ricerca
function load_data(page, query = '') {
    var order = '';
    var only = '';
    var column = '';
    //ordinamento
    if (document.getElementById("order-a-to-z").checked) {
        order = 'ASC';
    }
    if (document.getElementById("order-z-to-a").checked) {
        order = 'DESC';
    }
    //includi attivi
    if (!document.getElementById("include-active").checked) {
        if (only != '') {
            only += ' AND status <> "1"';
        } else {
            only += ' status <> "1"';
        }
    }
    //includi disattivati
    if (!document.getElementById("include-disable").checked) {
        if (only != '') {
            only += ' AND status <> "2"';
        } else {
            only += ' status <> "2"';
        }
    }
    //includi non verificati
    if (!document.getElementById("include-not-verified").checked) {
        if (only != '') {
            only += ' AND status <> "0"';
        } else {
            only += ' status <> "0"';
        }
    }
    //includi admin
    if (!document.getElementById("include-admin").checked) {
        if (only != '') {
            only += ' AND type <> "0"';
        } else {
            only += ' type <> "0"';
        }
    }
    //includi utenti
    if (!document.getElementById("include-user").checked) {
        if (only != '') {
            only += ' AND type <> "1"';
        } else {
            only += ' type <> "1"';
        }
    }
    //includi autore
    if (!document.getElementById("include-author").checked) {
        if (only != '') {
            only += ' AND type <> "2"';
        } else {
            only += ' type <> "2"';
        }
    }
    column = document.getElementById("search-for").value;
    $.ajax({
        url: "statics/php/users.php?search",
        method: "POST",
        data: {
            page: page,
            query: query,
            order: order,
            only, only,
            column: column,
        },
        success: function (data) {
            debug(data);
            $('#list-users').html(data);
        }
    });
}
//modifica utente
function modal_edit(id) {
    var edit_id = id;
    $.ajax({
        url: 'statics/php/users.php?get=' + edit_id,
        success: function (data) {
            debug(data);
            var array = JSON.parse(data);
            document.getElementById("id-edit").value = array.id;
            document.getElementById("username-edit").value = array.username;
            document.getElementById("name-edit").value = array.name;
            document.getElementById("surname-edit").value = array.surname;
            document.getElementById("email-edit").value = array.email;
            var img = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/assets/users/" + array.id + "/" + array.avatar;
            document.getElementById("avatar_preview_edit").src = img;
            document.getElementById("type-account-edit").value = array.type;
            document.getElementById("status-account-edit").value = array.status;
            document.getElementById("username_title-edit").innerHTML = "Modifica: " + array.username;
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
//eliminazione utente
function delete_user(id) {
    var delete_id = id;
    $.ajax({
        url: 'statics/php/users.php?delete=' + delete_id,
        success: function (data) {
            debug(data);
            var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
            $.post(url,
                function (data) {
                    debug(data);
                    document.getElementById("info").innerHTML = data;
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
                }
            );
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
//freccia di cambio stato
function arrow(direction, option, id) {
    $.ajax({
        url: 'statics/php/users.php?direction=' + direction + '&option=' + option + '&id=' + id,
        success: function (response) {
            debug(response);
            if (response.includes("&type=danger")) {
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
            } else {
                document.getElementById('account_' + option + '_' + id).innerHTML = response;
            }
        }
    });
}
//al caricamento della pagina
$(document).ready(function () {
    check_password_bar();
    init_search_preference();
    load_data(1);
    $(document).on('click', '.page-link', function () {
        var page = $(this).data('page_number');
        current_page = page;
        var query = $('#search_box').val();
        load_data(page, query);
    });
    $('#search_box').keyup(function () {
        var query = $('#search_box').val();
        load_data(1, query);
    });
    //modifica utente
    $("#form-edit").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/users.php?edit',
            data: formData,
            success: function (data) {
                debug(data);
                if (data.includes("&type=success")) {
                    var query = $('#search_box').val();
                    load_data(current_page, query);
                }
                var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
                $.post(url,
                    function (data) {
                        document.getElementById("info-modal-edit").innerHTML = data;
                        setTimeout(function () {
                            document.getElementById("info-modal-edit").innerHTML = "";
                        }, 2500);
                    }
                );
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    //aggiunta utente
    $("#form-add").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/users.php?add',
            data: formData,
            success: function (data) {
                debug(data);
                if (data.includes("&type=success")) {
                    var query = $('#search_box').val();
                    load_data(current_page, query);
                    $('#modal-add').modal('hide');
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
                    document.getElementById('form-add').reset();
                    var div_bar = '#password-strength-meter';
                    var bar = $(div_bar);
                    $(bar).attr('class', 'progress-bar bg-danger').css('width', '0%');
                    $(bar).attr('class', 'progress-bar bg-danger').css('width', '0%');
                } else {
                    var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
                    $.post(url,
                        function (data) {
                            debug(data);
                            document.getElementById("info-modal-add").innerHTML = data;
                            setTimeout(function () {
                                document.getElementById("info-modal-add").innerHTML = "";
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
    //cambio dinamico immagini
    avatar_edit.onchange = evt => {
        const [file] = avatar_edit.files
        if (file) {
            avatar_preview_edit.src = URL.createObjectURL(file)
        }
    }
    avatar_add.onchange = evt => {
        const [file] = avatar_add.files
        if (file) {
            avatar_preview_add.src = URL.createObjectURL(file)
        }
    }
});
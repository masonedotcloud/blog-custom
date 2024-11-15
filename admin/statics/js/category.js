/*
    category.js
    gestione delle chiamate alla gestione della newsletter
*/
//variabile per la pagina attuale
var current_page = 1;
//cambio della classe
function change_class(id, status) {
    var div = document.getElementById("status-category-" + id);
    if (div != null) {
        if (status == 1) {
            document.getElementById("status-category-" + id).className = "btn btn-primary";
        } else {
            document.getElementById("status-category-" + id).className = "btn btn-outline-primary";
        }
    }
}
//controllo delle preferenze al cambio e le salva
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
    if (column == 'parent') {
        document.getElementById('search_box').placeholder = "Ricerca per genitore";
    } else if (column == 'name') {
        document.getElementById('search_box').placeholder = "Ricerca per nome";
    }
    var query = $('#search_box').val();
    load_data(current_page, query);
    setCookie("order-a-to-z_category", document.getElementById("order-a-to-z").checked, 30);
    setCookie("order-z-to-a_category", document.getElementById("order-z-to-a").checked, 30);
    setCookie("include-active_category", document.getElementById("include-active").checked, 30);
    setCookie("include-disable_category", document.getElementById("include-disable").checked, 30);
    setCookie("include-father_category", document.getElementById("include-father").checked, 30);
    setCookie("include-son_category", document.getElementById("include-son").checked, 30);
    setCookie("search-for_category", document.getElementById("search-for").value, 30);
}
//al caricamento della pagina riempimento delle opzioni di ricerca
function init_search_preference() {
    if (getCookie("order-a-to-z_category") != "" && getCookie("order-a-to-z_category") != "false") {
        document.getElementById("order-a-to-z").checked = true;
    }
    if (getCookie("order-z-to-a_category") != "" && getCookie("order-z-to-a_category") != "false") {
        document.getElementById("order-z-to-a").checked = true;
    }
    if (getCookie("include-active_category") != "" && getCookie("include-active_category") != "false") {
        document.getElementById("include-active").checked = true;
    }
    if (getCookie("include-disable_category") != "" && getCookie("include-disable_category") != "false") {
        document.getElementById("include-disable").checked = true;
    }
    if (getCookie("include-father_category") != "" && getCookie("include-father_category") != "false") {
        document.getElementById("include-father").checked = true;
    }
    if (getCookie("include-son_category") != "" && getCookie("include-son_category") != "false") {
        document.getElementById("include-son").checked = true;
    }
    if (getCookie("search-for_category") != "") {
        document.getElementById("search-for").value = getCookie("search-for_category");
        var column = document.getElementById("search-for").value;
        if (column == 'parent') {
            document.getElementById('search_box').placeholder = "Ricerca per genitore";
        } else if (column == 'name') {
            document.getElementById('search_box').placeholder = "Ricerca per nome";
        }
    }
    if (getCookie("order-a-to-z_category") == '' && getCookie("order-z-to-a_category") == '' && getCookie("include-active_category") == '' && getCookie("include-disable_category") == '' && getCookie("include-father_category") == '' && getCookie("include-son_category") == '' && getCookie("search-for_category") == '') {
        document.getElementById("order-a-to-z").checked = true;
        document.getElementById("include-active").checked = true;
        document.getElementById("include-disable").checked = true;
        document.getElementById("include-father").checked = true;
        document.getElementById("include-son").checked = true;
        document.getElementById("search-for").value = 'name';
        document.getElementById('search_box').placeholder = "Ricerca per nome";
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
    //categorie attive
    if (!document.getElementById("include-active").checked) {
        if (only != '') {
            only += ' AND e.status <> "1"';
        } else {
            only += ' e.status <> "1"';
        }
    }
    //categprie disattivate
    if (!document.getElementById("include-disable").checked) {
        if (only != '') {
            only += ' AND e.status <> "0"';
        } else {
            only += ' e.status <> "0"';
        }
    }
    //categorie padri
    if (!document.getElementById("include-father").checked) {
        if (only != '') {
            only += ' AND e.parent <> "-1"';
        } else {
            only += ' e.parent <> "-1"';
        }
    }
    //categorie figlio
    if (!document.getElementById("include-son").checked) {
        if (only != '') {
            only += ' AND e.parent = "-1"';
        } else {
            only += ' e.parent = "-1"';
        }
    }
    //colonna di ricerca
    column = document.getElementById("search-for").value;
    $.ajax({
        url: "statics/php/category.php?search",
        method: "POST",
        data: {
            page: page,
            query: query,
            order: order,
            only, only,
            column: column,
        },
        success: function (data) {
            $('#list-category').html(data);
        }
    });
    //ricarico categorie
    var link = "statics/php/category.php?option_category";
    $.ajax({
        url: link,
        success: function (data) {
            debug(data);
            $('#parent-category-edit').html(data);
            document.getElementById("parent-category-add").value = -1;
            $('#parent-category-add').html(data);
        }
    });
}
//attiva-disattiva categoria
function status_category(id) {
    var status_id = id;
    $.ajax({
        url: 'statics/php/category.php?status&id=' + status_id,
        success: function (data) {
            debug(data);
            if (data.includes("&type=danger")) {
                var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
                $.post(url,
                    function (data) {
                        document.getElementById("info").innerHTML = data;
                        setTimeout(function () {
                            document.getElementById("info").innerHTML = "";
                        }, 2500);
                    }
                );
            } else {
                var div = document.getElementById("status-category-" + id);
                if (hasClass(div, "btn btn-outline-primary")) {
                    change_class(id, 1);
                } else if (hasClass(div, "btn btn-primary")) {
                    change_class(id, 0);
                }
                if (data != null) {
                    var value = new Array();
                    value = JSON.parse(data);
                    for (var k in value) {
                        change_class(value[k][0], value[k][1]);
                    }
                }
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
//elimina categoria
function delete_category(id) {
    var delete_id = id;
    $.ajax({
        url: 'statics/php/category.php?delete=' + delete_id,
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
//modifica della categoria
function modal_edit(id) {
    var edit_id = id;
    $.ajax({
        url: 'statics/php/category.php?get=' + edit_id,
        success: function (data) {
            var array = JSON.parse(data);
            document.getElementById("id-edit").value = array.id;
            document.getElementById("name-edit").value = array.name;
            document.getElementById("status-category-edit").value = array.status;
            var link = "statics/php/category.php?option_category";
            $.ajax({
                url: link,
                success: function (data) {
                    $('#parent-category-edit').html(data);
                    document.getElementById("parent-category-edit").value = array.parent;
                }
            });
            document.getElementById("description-edit").value = array.description;
            document.getElementById("name-title-edit").innerHTML = "Modifica: " + array.name;
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
//al caricamento della pagina
$(document).ready(function () {
    //modifica di una categoria
    $("#form-edit").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/category.php?edit',
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
                        debug(data);
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
    //aggiunta di una categoria
    $("#form-add").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/category.php?add',
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
    })
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
});
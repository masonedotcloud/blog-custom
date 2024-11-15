/*
    posts.js
    ajax per la gestione della pagina dei posts
*/
//variabili per le pagine
var current_page = 1;
//variabile per i click
var click_for_reset = 0;
//variabili per l'editor
var up_url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/froala/php/upload.php";
var del_url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/froala/php/delete.php";
var img_folder = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/froala/php/image_manager.php";
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
    if (column == 'title') {
        document.getElementById('search_box').placeholder = "Ricerca per titolo";
    } else if (column == 'm.username') {
        document.getElementById('search_box').placeholder = "Ricerca per autore";
    } else if (column == 'c.name') {
        document.getElementById('search_box').placeholder = "Ricerca per categoria";
    } else if (column == 'content') {
        document.getElementById('search_box').placeholder = "Ricerca nel contenuto";
    }
    var query = $('#search_box').val();
    load_data(current_page, query);
    setCookie("order-a-to-z_posts", document.getElementById("order-a-to-z").checked, 30);
    setCookie("order-z-to-a_posts", document.getElementById("order-z-to-a").checked, 30);
    setCookie("search-for_posts", document.getElementById("search-for").value, 30);
    setCookie("include-active_posts", document.getElementById("include-active").checked, 30);
    setCookie("include-disable_posts", document.getElementById("include-disable").checked, 30);
    setCookie("include-active-category_posts", document.getElementById("include-active-category").checked, 30);
    setCookie("include-disable-category_posts", document.getElementById("include-disable-category").checked, 30);
    setCookie("include-active-author_posts", document.getElementById("include-active-author").checked, 30);
    setCookie("include-disable-author_posts", document.getElementById("include-disable-author").checked, 30);
    setCookie("include-not-author_posts", document.getElementById("include-not-author").checked, 30);
    setCookie("include-type-author_posts", document.getElementById("include-type-author").checked, 30);
}
//al caricamento della pagina riempimento delle opzioni di ricerca
function init_search_preference() {
    if (getCookie("order-a-to-z_posts") != "" && getCookie("order-a-to-z_posts") != "false") {
        document.getElementById("order-a-to-z").checked = true;
    }
    if (getCookie("order-z-to-a_posts") != "" && getCookie("order-z-to-a_posts") != "false") {
        document.getElementById("order-z-to-a").checked = true;
    }
    if (getCookie("search-for_posts") != "") {
        document.getElementById("search-for").value = getCookie("search-for_posts");
        var column = document.getElementById("search-for").value;
        if (column == 'title') {
            document.getElementById('search_box').placeholder = "Ricerca per titolo";
        } else if (column == 'm.username') {
            document.getElementById('search_box').placeholder = "Ricerca per autore";
        } else if (column == 'c.name') {
            document.getElementById('search_box').placeholder = "Ricerca per categoria";
        } else if (column == 'content') {
            document.getElementById('search_box').placeholder = "Ricerca nel contenuto";
        }
    }
    if (getCookie("include-active_posts") != "" && getCookie("include-active_posts") != "false") {
        document.getElementById("include-active").checked = true;
    }
    if (getCookie("include-disable_posts") != "" && getCookie("include-disable_posts") != "false") {
        document.getElementById("include-disable").checked = true;
    }
    if (getCookie("include-active-category_posts") != "" && getCookie("include-active-category_posts") != "false") {
        document.getElementById("include-active-category").checked = true;
    }
    if (getCookie("include-disable-category_posts") != "" && getCookie("include-disable-category_posts") != "false") {
        document.getElementById("include-disable-category").checked = true;
    }
    if (getCookie("include-active-author_posts") != "" && getCookie("include-active-author_posts") != "false") {
        document.getElementById("include-active-author").checked = true;
    }
    if (getCookie("include-disable-author_posts") != "" && getCookie("include-disable-author_posts") != "false") {
        document.getElementById("include-disable-author").checked = true;
    }
    if (getCookie("include-not-author_posts") != "" && getCookie("include-not-author_posts") != "false") {
        document.getElementById("include-not-author").checked = true;
    }
    if (getCookie("include-type-author_posts") != "" && getCookie("include-type-author_posts") != "false") {
        document.getElementById("include-type-author").checked = true;
    }
    if (getCookie("order-a-to-z_posts") == '' && getCookie("order-z-to-a_posts") == '' && getCookie("search-for_posts") == '' && getCookie("include-active_posts") == '' && getCookie("include-disable_posts") == '' && getCookie("include-disable-category_posts") == '' && getCookie("include-active-category_posts") == '' && getCookie("include-disable-author_posts") == '' && getCookie("include-active-author_posts") == '' && getCookie("include-not-author_posts") == '' && getCookie("include-type-author_posts") == '') {
        document.getElementById("order-a-to-z").checked = true;
        document.getElementById("search-for").value = 'title';
        document.getElementById('search_box').placeholder = "Ricerca per titolo";
        document.getElementById("include-active").checked = true;
        document.getElementById("include-disable").checked = true;
        document.getElementById("include-active-category").checked = true;
        document.getElementById("include-disable-category").checked = true;
        document.getElementById("include-active-author").checked = true;
        document.getElementById("include-disable-author").checked = true;
        document.getElementById("include-not-author").checked = true;
        document.getElementById("include-type-author").checked = true;
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
    //posts attive
    if (!document.getElementById("include-active").checked) {
        if (only != '') {
            only += ' AND e.status <> "1"';
        } else {
            only += ' e.status <> "1"';
        }
    }
    //post disattivati
    if (!document.getElementById("include-disable").checked) {
        if (only != '') {
            only += ' AND e.status <> "0"';
        } else {
            only += ' e.status <> "0"';
        }
    }
    //con categorie attive
    if (!document.getElementById("include-active-category").checked) {
        if (only != '') {
            only += ' AND s.status <> "1"';
        } else {
            only += ' s.status <> "1"';
        }
    }
    //con categorie disattivate
    if (!document.getElementById("include-disable-category").checked) {
        if (only != '') {
            only += ' AND s.status <> "0"';
        } else {
            only += ' s.status <> "0"';
        }
    }
    //con autori attivi
    if (!document.getElementById("include-active-author").checked) {
        if (only != '') {
            only += ' AND u.status <> "1"';
        } else {
            only += ' u.status <> "1"';
        }
    }
    //con autori disattivati
    if (!document.getElementById("include-disable-author").checked) {
        if (only != '') {
            only += ' AND u.status <> "2"';
        } else {
            only += ' u.status <> "2"';
        }
    }
    //con autori non verificati
    if (!document.getElementById("include-not-author").checked) {
        if (only != '') {
            only += ' AND u.status <> "0"';
        } else {
            only += ' u.status <> "0"';
        }
    }
    //con vecchi autori
    if (!document.getElementById("include-type-author").checked) {
        if (only != '') {
            only += ' AND u.type <> "1"';
        } else {
            only += ' u.type <> "1"';
        }
    }
    //aggiornamento della lista categorie
    var link = "statics/php/posts.php?option_category";
    $.ajax({
        url: link,
        success: function (data) {
            $('#category-add').html(data);
            $('#category-edit').html(data);
            document.getElementById("category-add").value = 1;
        }
    });
    //aggiornamento lista autori
    var link = "statics/php/posts.php?option_author";
    $.ajax({
        url: link,
        success: function (data) {
            debug(data);
            var link = "statics/php/posts.php?get_session_id";
            $.ajax({
                url: link,
                success: function (response) {
                    debug(response);
                    $('#author-add').html(data);
                    $('#author-edit').html(data);
                    document.getElementById("author-add").value = response;
                }
            });
        }
    });
    //colonna di ricerca
    column = document.getElementById("search-for").value;
    $.ajax({
        url: "statics/php/posts.php?search",
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
            $('#list-posts').html(data);
        }
    });
}
//cambiamento delle opzione con le frecce nella index della pagina posts
function arrow(direction, option, id) {
    $.ajax({
        url: 'statics/php/posts.php?direction=' + direction + '&option=' + option + '&id=' + id,
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
                document.getElementById('post_' + option + '_' + id).innerHTML = response;
            }
        }
    });
}
//eliminazione del posts
function delete_posts(id) {
    var delete_id = id;
    $.ajax({
        url: 'statics/php/posts.php?delete=' + delete_id,
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
//apertura modale di modifica
function modal_edit(id) {
    var edit_id = id;
    $.ajax({
        url: 'statics/php/posts.php?get=' + edit_id,
        success: function (data) {
            debug(data);
            var array = JSON.parse(data);
            document.getElementById("id-edit").value = array.id;
            document.getElementById("title-edit").value = array.title;
            if (array.status) {
                document.getElementById("status-edit").checked = true;
            } else {
                document.getElementById("status-edit").checked = false;
            }
            var img = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/assets/posts/" + array.id + "/" + array.cover;
            document.getElementById("cover_preview_edit").src = img;
            document.getElementById("category-edit").value = array.category;
            document.getElementById("author-edit").value = array.author;
            document.getElementById("edit-content").innerHTML = '<textarea id="editor-edit" name="content_data">' + array.content + '</textarea>';
            var editor = new FroalaEditor('#editor-edit', {
                events: {
                    'image.beforeRemove': function ($img) {
                        var img_link = $img[0].src
                        $.ajax({
                            url: del_url,
                            method: "POST",
                            data: {
                                src: img_link,
                            },
                            success: function (data) {
                                debug(data);
                            }
                        });
                    },
                    'file.unlink': function ($img) {
                        var img_link = $img.href;
                        $.ajax({
                            url: del_url,
                            method: "POST",
                            data: {
                                src: img_link,
                            },
                            success: function (data) {
                                debug(data);
                            }
                        });
                    }
                },
                // Set the file upload parameter.
                fileUploadParam: 'file',
                // Set the file upload URL.
                fileUploadURL: up_url + '?folder=file&fieldname=file',
                // Additional upload params.
                fileUploadParams: { id: 'my_editor' },
                // Set request type.
                fileUploadMethod: 'POST',
                // Set max file size to 20MB.
                fileMaxSize: 20 * 1024 * 1024,
                // Allow to upload any file.
                fileAllowedTypes: ['*'],
                zIndex: 2501,
                imageManagerDeleteURL: del_url,
                imageManagerLoadURL: img_folder,
                codeMirror: true,
                imageUploadURL: up_url + '?folder=images&fieldname=file',
                imageUploadParams: {
                    id: 'my_editor'
                },
                backgroundColor: '#F0F2F5;',
                height: 600,
            });
            document.getElementById("name-title-edit").innerHTML = "Modifica: " + array.title;
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
//controllo di doppio click per il rester del modale di aggiunta
function control_two_click() {
    click_for_reset++;
    document.getElementById("reset-add-button").innerHTML = 'Reset (Sei sicuro?)';
    if (click_for_reset == 2) {
        document.getElementById("form-add").reset();
        document.getElementById("category-add").value = 1;
        click_for_reset = 0;
        document.getElementById("reset-add-button").innerHTML = 'Reset';
        var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/assets/posts/cover.png";
        document.getElementById("cover_preview").src = url
    }
}
//editor iniezione
var editor = new FroalaEditor('#editor-add, #editor-edit', {
    events: {
        'image.beforeRemove': function ($img) {
            var img_link = $img[0].src
            $.ajax({
                url: del_url,
                method: "POST",
                data: {
                    src: img_link,
                },
                success: function (data) {
                    debug(data);
                }
            });
        },
        'file.unlink': function ($img) {
            var img_link = $img.href;
            $.ajax({
                url: del_url,
                method: "POST",
                data: {
                    src: img_link,
                },
                success: function (data) {
                    debug(data);
                }
            });
        }
    },
    // Set the file upload parameter.
    fileUploadParam: 'file',
    // Set the file upload URL.
    fileUploadURL: up_url + '?folder=file&fieldname=file',
    // Additional upload params.
    fileUploadParams: { id: 'my_editor' },
    // Set request type.
    fileUploadMethod: 'POST',
    // Set max file size to 20MB.
    fileMaxSize: 20 * 1024 * 1024,
    // Allow to upload any file.
    fileAllowedTypes: ['*'],
    zIndex: 2501,
    imageManagerDeleteURL: del_url,
    imageManagerLoadURL: img_folder,
    codeMirror: true,
    imageUploadURL: up_url + '?folder=images&fieldname=file',
    imageUploadParams: {
        id: 'my_editor'
    },
    height: 600,
});
//al caricamento della pagina
$(document).ready(function () {
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
    //immagine dinamiche
    cover_add.onchange = evt => {
        const [file] = cover_add.files
        if (file) {
            cover_preview_add.src = URL.createObjectURL(file)
        }
    }
    cover_edit.onchange = evt => {
        const [file] = cover_edit.files
        if (file) {
            cover_preview_edit.src = URL.createObjectURL(file)
        }
    }
    //form di modica di un post
    $("#form-edit").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/posts.php?edit',
            data: formData,
            success: function (data) {
                debug(data);
                if (data.includes("&type=success")) {
                    $.ajax({
                        url: 'statics/php/posts.php?get=' + document.getElementById('id-edit').value,
                        success: function (data2) {
                            debug(data2);
                            var array = JSON.parse(data2);
                            setTimeout(function () {
                                document.getElementById("category-edit").value = array.category;
                                document.getElementById("author-edit").value = array.author;
                            }, 100);

                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
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
    //aggiunta di un post
    $("#form-add").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/posts.php?add',
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
                            document.getElementById("form-add").reset();
                            document.getElementById("category-add").value = 1;
                            click_for_reset = 0;
                            document.getElementById("reset-add-button").innerHTML = 'Reset';
                            document.getElementById("editor-add").innerHTML = 'Reset';
                            var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/assets/posts/cover.png";
                            document.getElementById("cover_preview_add").src = url
                            setTimeout(function () {
                                document.getElementById("info").innerHTML = "";
                            }, 2500);
                        }
                    );
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
});
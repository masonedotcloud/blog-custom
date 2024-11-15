/*
    profile.js
    gestione della sezione privata
*/
//restituisce l'email della sessione dell'utente
jQuery.extend({
    getValues: function (url) {
        var result = null;
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'text',
            async: false,
            success: function (data) {
                debug(data);
                result = data;
            }
        });
        return result;
    }
});
var email = $.getValues("statics/php/profile.php?email");
//controllo per l'email valida
function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}
//controllo attivo nell'input dell'email
function check_change_email() {
    var input = document.getElementById("email").value;
    var status = document.getElementById('email-status');
    var verified = '<span class="cursor-pointer"><i class="bi bi-check-lg"></i></span>';
    var notverified = '<span onclick="send_code_change_mail(\'info-modal-email\');" class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#modal-code">Conferma email</span>';
    var notexist = '<span>Email non valida</span>';
    if (validateEmail(input)) {
        if (email != input) {
            if (status != notverified) {
                status.innerHTML = notverified;
                status.setAttribute("data-bs-original-title", "Clicca per verificare l'email");
            }
        } else if (email == input) {
            if (status != verified) {
                status.innerHTML = verified;
                status.setAttribute("data-bs-original-title", "Email confermata");
            } else {
                email = input;
                status.setAttribute("data-bs-original-title", "Clicca per verificare l'email");
            }
        }
    } else {
        status.innerHTML = notexist;
        status.setAttribute("data-bs-original-title", "Email non valida");
    }
}
//invio del codice per la conferma della nuova email
function send_code_change_mail(info) {
    var email_to = document.getElementById("email").value;
    var url = "statics/php/profile.php?send_code_change_mail";
    $.ajax({
        url: url,
        method: "POST",
        data: {
            email: email_to,
        },
        success: function (data) {
            debug(data);
            var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
            $.post(url,
                function (data) {
                    debug(data);
                    console.log(data);
                    document.getElementById(info).innerHTML = data;
                    setTimeout(function () {
                        document.getElementById(info).innerHTML = "";
                    }, 2500);
                }
            );
        }
    });
}
//controllo del codice per la verifica dell'email
function check_code_change_mail() {
    var code = document.getElementById("code-modal").value;
    var email_form = document.getElementById("email").value;
    $.ajax({
        url: 'statics/php/profile.php?code=' + code + '&email=' + email_form,
        success: function (data) {
            debug(data);
            if (data == 'email-confirm-success') {
                $('#modal-code').modal('hide');
                document.getElementById('email-status').innerHTML = '<span class="cursor-pointer"><i class="bi bi-check-lg"></i></span>';
                document.getElementById('email-status').setAttribute("data-bs-original-title", "Email confermata")
                document.getElementById("code-modal").value = '';
                var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php?message=Email confermata&type=success";
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
                var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
                $.post(url,
                    function (data) {
                        debug(data);
                        document.getElementById("info-modal-email").innerHTML = data;
                        setTimeout(function () {
                            document.getElementById("info-modal-email").innerHTML = "";
                        }, 2500);
                    }
                );
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
//eliminazione dell'account
function delete_account() {
    var confirm = document.getElementById('delete-confirm').value;
    if (confirm == "elimina") {
        var url = 'statics/php/profile.php?delete';
        $.post(url,
            function (data) {
                debug(data);
                if (data != "success-delete") {
                    document.getElementById('delete-confirm').value = "";
                    $('#modal-delete').modal('hide');
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
            }
        );
    } else {
        var data = '?message=devi confermare&type=danger';
        var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
        $.post(url,
            function (data) {
                debug(data);
                document.getElementById("info-modal-delete").innerHTML = data;
                setTimeout(function () {
                    document.getElementById("info-modal-delete").innerHTML = "";
                }, 2500);
            }
        );
    }
}
//eliminazione della richiesta di cambio password per via della password dimenticata
function delete_request_reset_password() {
    var url = 'statics/php/profile.php?delete_reset_password';
    $.post(url,
        function (data) {
            debug(data);
            if (data.includes("&type=success")) {
                $(".tooltip").tooltip("hide");
                const element = document.getElementById("delete-request-reset-password");
                element.remove();
            }
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
    );
}
//caricamento display per i preferiti
function load_data(page, query = '') {
    $.ajax({
        url: "statics/php/profile.php?favorites_list",
        method: "POST",
        data: {
            page: page,
            query: query,
        },
        success: function (data) {
            console.log(data);
            $('#personal-favorites-list').html(data);
        }
    });
    masonryUpdate();
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
                load_data(1);
            }
        }
    );
}
//al caricamento della pagina
$(document).ready(function () {
    //cambio live delle immagini del profilo al caricamento
    if (document.getElementById("avatar") != null) {
        avatar.onchange = evt => {
            const [file] = avatar.files
            if (file) {
                avatar_preview.src = URL.createObjectURL(file)
            }
        }
    }
    //click di conferma per la modifica dei dati
    $("#form-modifica").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'statics/php/profile.php?edit',
            data: formData,
            success: function (data) {
                debug(data);
                var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
                $.post(url,
                    function (data) {
                        debug(data);
                        document.getElementById("info").innerHTML = data;
                        document.getElementById("password-old").value = '';
                        document.getElementById("password").value = '';
                        document.getElementById("password-check").value = '';
                        var div_bar = '#password-strength-meter';
                        var bar = $(div_bar);
                        $(bar).attr('class', 'progress-bar bg-danger').css('width', '0%');
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
    });
    //controllo password live
    check_password_bar();
    //check per le preferenze
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
});
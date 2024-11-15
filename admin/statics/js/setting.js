/*
    setting.js
    ajax per la gestione della pagina delle impostazioni
*/
//riempimento con di dati del sito
function fill_data() {
    $.ajax({
        url: 'statics/php/setting.php?fill_data',
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function (data) {
            debug(data);
            var site_data_string = JSON.stringify(data);
            var site_data = JSON.parse(site_data_string);
            document.getElementById("name").value = site_data.name;
            document.getElementById("email").value = site_data.email;
            document.getElementById("description").innerHTML = site_data.description;
            document.getElementById("phrase").value = site_data.phrase;
            if (site_data.login == 0) {
                document.getElementById("login").checked = false;
            } else {
                document.getElementById("login").checked = true;
            }
            if (site_data.register == 0) {
                document.getElementById("register").checked = false;
            } else {
                document.getElementById("register").checked = true;
            }
            if (site_data.posts == 0) {
                document.getElementById("posts").checked = false;
            } else {
                document.getElementById("posts").checked = true;
            }
            $.ajax({
                url: 'statics/php/site.php?logo',
                success: function (response) {
                    debug(response);
                    document.getElementById("image_preview").src = response;
                }
            });
            $.ajax({
                url: 'statics/php/setting.php?get_debug',
                success: function (response) {
                    debug(response);
                    if (response == 'false') {
                        document.getElementById("debug").checked = false;
                    } else {
                        document.getElementById("debug").checked = true;
                    }
                }
            });
        }
    });
}
//cambiamento live della preview dell'immagine
image.onchange = evt => {
    const [file] = image.files
    if (file) {
        image_preview.src = URL.createObjectURL(file)
    }
}
//form dei dati del sito
$("#data").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'statics/php/setting.php?update',
        data: formData,
        success: function (data) {
            debug(data);
            var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
            $.post(url,
                function (data) {
                    debug(data);
                    document.getElementById("info").innerHTML = data;
                    $.ajax({
                        url: 'statics/php/site.php?logo',
                        success: function (response) {
                            debug(response);
                            const linkElement = document.querySelector('link[rel=icon]');
                            if (linkElement.href != response) {
                                linkElement.href = response;
                            }
                        }
                    });
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
//attiva o disattiva il login
function login_switch() {
    var url = 'statics/php/setting.php?login';
    $.post(url,
        function (data) {
            debug(data);
            if (data.includes("&type=danger")) {
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
}
//attiva o disattiva visualizzazione posts
function posts_switch() {
    var url = 'statics/php/setting.php?posts';
    $.post(url,
        function (data) {
            debug(data);
            if (data.includes("&type=danger")) {
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
}
//attiva o disattiva le registrazioni
function register_switch() {
    var url = 'statics/php/setting.php?register';
    $.post(url,
        function (data) {
            debug(data);
            if (data.includes("&type=error")) {
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
}
//attiva o disattiva debug
function debug_switch() {
    var url = 'statics/php/setting.php?debug';
    $.post(url,
        function (data) {
            debug(data);
            if (data.includes("&type=error")) {
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
}
//al caricamento della pagina
fill_data();
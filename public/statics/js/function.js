function eye_password(div) {
    if (document.getElementById(div).type == 'password') {
        document.getElementById(div).type = 'text';
        document.getElementById('button-eye-' + div).className = "bi bi-eye-slash-fill";
    } else {
        document.getElementById(div).type = 'password';
        document.getElementById('button-eye-' + div).className = "bi-eye-fill";
    }
}
function logo(div) {
    $.ajax({
        url: 'statics/php/site.php?logo',
        type: 'GET',
        success: function (response) {
            if (document.getElementById(div).src != response) {
                document.getElementById(div).src = response;
            }
        }
        
    });
}
function debug(data) {
    var link = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/functions.php?debug_js";
    $.ajax({
        url: link,
        success: function (response) {
            if (response == 'true') {
                console.log(data);
            }
        }
    });

}

function random_username(div, info) {
    var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/functions.php?random_name";
    $.post(url,
        function (data) {
            if (data.includes("&type=danger")) {
                var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
                $.post(url,
                    function (data) {
                        document.getElementById(info).innerHTML = data;
                        setTimeout(function () {
                            document.getElementById(info).innerHTML = "";
                        }, 2500);
                    }
                );
            } else {
                document.getElementById(div).value = data;
            }
        }
    );
}

function check_password_bar(div_bar = '#password-strength-meter', div_password = '#password') {
    var bar = $(div_bar);
    $(div_password).on('input', function () {
        var val = password.value,
            result = zxcvbn(val),
            score = result.score;
        switch (score) {
            case 0:
                $(bar).attr('class', 'progress-bar bg-danger')
                    .css('width', '1%');
                break;
            case 1:
                $(bar).attr('class', 'progress-bar bg-danger')
                    .css('width', '25%');
                break;
            case 2:
                $(bar).attr('class', 'progress-bar bg-warning')
                    .css('width', '50%');
                break;
            case 3:
                $(bar).attr('class', 'progress-bar bg-info')
                    .css('width', '75%');
                break;
            case 4:
                $(bar).attr('class', 'progress-bar bg-success')
                    .css('width', '100%');
                break;
        }
    });
}

function send_code(info) {
    var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/functions.php?send_code";
    $.post(url,
        function (data) {
            var url = location.protocol + "//" + location.host + "/alessandromasone.altervista.org" + "/public/statics/php/alert.php" + data;
            $.post(url,
                function (data) {
                    document.getElementById(info).innerHTML = data;
                    setTimeout(function () {
                        document.getElementById(info).innerHTML = "";
                    }, 2500);
                }
            );

        }
    );
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function hasClass(element, cls) {
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}

function masonryUpdate() {

    setTimeout(function () {
        var $container = $('#grid');
        $container.masonry();
    }, 100);
}


Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}
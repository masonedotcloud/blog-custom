function PageName() {
    var path = window.location.pathname;
    var page = path.split("/").pop();
    return page.substring(0, page.lastIndexOf('.')) || page;
}

setInterval(function () {
    var link = location.protocol + '//' + location.host + "/alessandromasone.altervista.org" + '/public/statics/php/session.php?page=' + PageName();
    $.ajax({
        url: link,
        success: function (data) {
            if (data != "NULL") {
                window.location.href = data;
            }
        },
    });
}, 1000);

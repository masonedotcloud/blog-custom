function header_element() {
    $.ajax({
        url: 'statics/php/site.php?logo',
        success: function (response) {
            const linkElement = document.querySelector('link[rel=icon]');
            if (linkElement.href != response) {
                linkElement.href = response;
            }
        }
    });
}

header_element();
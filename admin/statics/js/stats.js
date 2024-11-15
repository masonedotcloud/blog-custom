google.charts.load('current', { packages: ['corechart', 'line', 'bar'] });
google.charts.setOnLoadCallback(drawChartAccess);
google.charts.setOnLoadCallback(drawChartSubscriber);
google.charts.setOnLoadCallback(drawChartNewsletter);
google.charts.setOnLoadCallback(drawChartCategory);
google.charts.setOnLoadCallback(drawChartPost);
//grafico accesso
function drawChartAccess() {
    $('#loading-access').show();
    var value = new Array();
    var max_value = '';
    $.ajax({
        url: 'statics/php/stats.php?access',
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function (response) {
            debug(response);
            value = JSON.stringify(response);
        }
    });
    $.ajax({
        url: 'statics/php/stats.php?max_value_access',
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function (response) {
            debug(response);
            var temp = JSON.stringify(response);
            max_value = JSON.parse(temp) + 5;

        }
    });
    var data = google.visualization.arrayToDataTable(JSON.parse(value), true);
    var options = {
        title: 'Visualizzazione negli ultimi 30 giorni',
        subtitle: 'Analisi giornaliera',
        legend: {
            position: 'none'
        },
        backgroundColor: {
            fill: '#F0F2F5',
            fillOpacity: 1
        },
        chartArea: {
            backgroundColor: {
                fill: '#F0F2F5',
                fillOpacity: 1
            },
        },
        vAxis: {
            format: '0',
            viewWindow: {
                min: 0,
                max: max_value,
            },
        },
    };
    var chart = new google.charts.Line(document.getElementById('linechart_access'));
    chart.draw(data, google.charts.Line.convertOptions(options));
    $('#loading-access').hide();
}
//grafico iscritti
function drawChartSubscriber() {
    $('#loading-subscriber').show();
    var value = new Array();
    var max_value = '';
    $.ajax({
        url: 'statics/php/stats.php?subscriber',
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function (response) {
            debug(response);
            value = JSON.stringify(response);
        }
    });
    $.ajax({
        url: 'statics/php/stats.php?max_value_subscriber',
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function (response) {
            debug(response);
            var temp = JSON.stringify(response);
            max_value = JSON.parse(temp) + 5;

        }
    });
    var data = google.visualization.arrayToDataTable(JSON.parse(value), true);
    var options = {
        title: 'Nuovi utenti negli ultimi 15 giorni',
        subtitle: 'Analisi giornaliera',
        legend: {
            position: 'none'
        },
        backgroundColor: {
            fill: '#F0F2F5',
            fillOpacity: 1
        },
        chartArea: {
            backgroundColor: {
                fill: '#F0F2F5',
                fillOpacity: 1
            },
        },
        vAxis: {
            format: '0',
            viewWindow: {
                min: 0,
                max: max_value,
            },
        },
    };
    var chart = new google.charts.Line(document.getElementById('linechart_subscriber'));
    chart.draw(data, google.charts.Line.convertOptions(options));
    $('#loading-subscriber').hide();
}
//grafico della newseltter
function drawChartNewsletter() {
    $('#loading-newsletter').show();
    var value = new Array();
    var max_value = '';
    $.ajax({
        url: 'statics/php/stats.php?newsletter',
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function (response) {
            debug(response);
            value = JSON.stringify(response);
        }
    });
    $.ajax({
        url: 'statics/php/stats.php?max_value_newsletter',
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function (response) {
            debug(response);
            var temp = JSON.stringify(response);
            max_value = JSON.parse(temp) + 5;

        }
    });
    var data = google.visualization.arrayToDataTable(JSON.parse(value), true);
    var options = {
        title: 'Registrazioni alla newsletter negli ultimi 15 giorni',
        subtitle: 'Analisi giornaliera',
        legend: {
            position: 'none'
        },
        backgroundColor: {
            fill: '#F0F2F5',
            fillOpacity: 1
        },
        chartArea: {
            backgroundColor: {
                fill: '#F0F2F5',
                fillOpacity: 1
            },
        },
        vAxis: {
            format: '0',
            viewWindow: {
                min: 0,
                max: max_value,
            },
        },
    };
    var chart = new google.charts.Line(document.getElementById('linechart_newsletter'));
    chart.draw(data, google.charts.Line.convertOptions(options));
    $('#loading-newsletter').hide();
}
//grafico per le categorie
function drawChartCategory() {
    $('#loading-category').show();
    var value = new Array();
    $.ajax({
        url: 'statics/php/stats.php?category',
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function (response) {
            debug(response);
            value = JSON.stringify(response);
        }
    });
    var data = google.visualization.arrayToDataTable(JSON.parse(value), true);
    var options = {
        title: '5 Categorie più visitate',
        subtitle: 'Nessun limite temporale',
        legend: {
            position: 'none'
        },
        backgroundColor: {
            fill: '#F0F2F5',
            fillOpacity: 1
        },
        chartArea: {
            backgroundColor: {
                fill: '#F0F2F5',
                fillOpacity: 1
            },
        },
        bar: {
            groupWidth: "90%"
        }
    };
    var chart = new google.charts.Bar(document.getElementById('barchart_category'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
    $('#loading-category').hide();
};
//grafico per i post
function drawChartPost() {
    $('#loading-post').show();
    var value = new Array();
    $.ajax({
        url: 'statics/php/stats.php?post',
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function (response) {
            debug(response);
            value = JSON.stringify(response);
        }
    });
    var data = google.visualization.arrayToDataTable(JSON.parse(value), true);
    var options = {
        title: '5 Post più visti',
        subtitle: 'Nessun limite temporale',
        legend: {
            position: 'none'
        },
        backgroundColor: {
            fill: '#F0F2F5',
            fillOpacity: 1
        },
        chartArea: {
            backgroundColor: {
                fill: '#F0F2F5',
                fillOpacity: 1
            },
        },
        bar: {
            groupWidth: "90%"
        }
    };
    var chart = new google.charts.Bar(document.getElementById('barchart_post'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
    $('#loading-post').hide();
};
//per il ridimensionamento della finestra
$(window).resize(function () {
    drawChartAccess();
    drawChartSubscriber();
    drawChartNewsletter();
    drawChartCategory();
    drawChartPost();
});
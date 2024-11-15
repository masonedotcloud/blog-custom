/*
    index.js
    ajax per la gestione della pagina principale
*/
//orologio live
function clockUpdate() {
  var date = new Date();
  $('.digital-clock');
  function addZero(x) {
    if (x < 10) {
      return x = '0' + x;
    } else {
      return x;
    }
  }
  function twelveHour(x) {
    if (x > 24) {
      return x = x - 24;
    } else if (x == 0) {
      return x = 24;
    } else {
      return x;
    }
  }
  var h = addZero(twelveHour(date.getHours()));
  var m = addZero(date.getMinutes());
  var s = addZero(date.getSeconds());
  $('.digital-clock').text(date);
}
clockUpdate();
//display statisiche live nella index come dettaglio
function number_element() {
  //categorie
  $.ajax({
    url: 'statics/php/site.php?category-number',
    success: function (response) {
      debug(response);
      if (document.getElementById("category-number") && document.getElementById("category-number").innerHTML != response) {
        document.getElementById("category-number").innerHTML = response;
      }
    }
  });
  //newsletter
  $.ajax({
    url: 'statics/php/site.php?newsletter-number',
    success: function (response) {
      debug(response);
      if (document.getElementById("newsletter-number") && document.getElementById("newsletter-number").innerHTML != response) {
        document.getElementById("newsletter-number").innerHTML = response;
      }
    }
  });
  //utenti
  $.ajax({
    url: 'statics/php/site.php?user-number',
    success: function (response) {
      debug(response);
      if (document.getElementById("user-number") && document.getElementById("user-number").innerHTML != response) {
        document.getElementById("user-number").innerHTML = response;
      }
    }
  });
  //impostazioni
  $.ajax({
    url: 'statics/php/site.php?site-status',
    success: function (response) {
      debug(response);
      if (document.getElementById("site-status") && document.getElementById("site-status").innerHTML != response) {
        document.getElementById("site-status").innerHTML = response;
      }
    }
  });
  //sito
  $.ajax({
    url: 'statics/php/site.php?site-stats',
    success: function (response) {
      debug(response);
      if (document.getElementById("last-stats") && document.getElementById("last-stats").innerHTML != response) {
        document.getElementById("last-stats").innerHTML = response;
      }
    }
  });
  //articoli
  $.ajax({
    url: 'statics/php/site.php?posts-number',
    success: function (response) {
      debug(response);
      if (document.getElementById("post-number") && document.getElementById("post-number").innerHTML != response) {
        document.getElementById("post-number").innerHTML = response;
      }
    }
  });
  //ciao
  $.ajax({
    url: 'statics/php/site.php?ciao',
    success: function (response) {
      debug(response);
      if (document.getElementById("site-benvenuto") && document.getElementById("site-benvenuto").innerHTML != response) {
        document.getElementById("site-benvenuto").innerHTML = response;
      }
    }
  });

}
number_element();
//controlla le statiche ogni X secondi
setInterval(function () {
  clockUpdate();
  number_element();
}, 1000);

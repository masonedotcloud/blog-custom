<?php 

require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');

$options = [
    array(
        'icon' => "globe2", //nome classe
        'title' => "Vai al sito", //titolo con il div (es. <h4></h4>)
        'summary' => InternetFile('', true), //sottotilo scritto in piccolo può essere anche non presente
        'link' => InternetFile('', true), //link a cui porta può essere anche vuoto e deve essere costituto anche da href="#"
        'target' => "_blank", //se è presente un href indicare come eseguirlo se lo si vuole in una nuova pagine
        'sidebar' => true, //se lo si vuole nella sidebar
        'status' => true, //opzione attiva o disattivata
        'index' => true, //se lo si vuole nell'index
        'onlyadmin' => false //se è soltanto per l'admin
    ),
    array(
        'icon' => "speedometer2",
        'title' => "Dashboard",
        'summary' => "",
        'link' => InternetFile('admin', true),
        'target' => "",
        'sidebar' => true,
        'status' => true,
        'index' => false,
        'onlyadmin' => false
    ),
    array(
        'icon' => "clock",
        'title' => "<h4 class=\"p-3\"><div class=\"digital-clock text-center\"></div></h4>",
        'summary' => "",
        'link' => "#clock",
        'target' => "",
        'sidebar' => false,
        'status' => true,
        'index' => true,
        'onlyadmin' => false
    ),
    array(
        'icon' => "bookmark",
        'title' => "Categorie",
        'summary' => '<div id="category-number"></div>',
        'link' => 'category',
        'target' => "",
        'sidebar' => true,
        'status' => true,
        'index' => true,
        'onlyadmin' => false
    ),
    array(
        'icon' => "file-post",
        'title' => "Post",
        'summary' => '<div id="post-number"></div>',
        'link' => "posts",
        'target' => "",
        'sidebar' => true,
        'status' => true,
        'index' => true,
        'onlyadmin' => false
    ),
    array(
        'icon' => "emoji-smile-upside-down",
        'title' => "Ave, Cesare!",
        'summary' => '<div id="site-benvenuto"></div>',
        'link' => '#name',
        'target' => "",
        'sidebar' => false,
        'status' => true,
        'index' => true,
        'onlyadmin' => false
    ),
    array(
        'icon' => "gear",
        'title' => "Impostazioni Sito",
        'summary' => '<div id="site-status"></div>',
        'link' => 'setting',
        'target' => "",
        'sidebar' => true,
        'status' => true,
        'index' => true,
        'onlyadmin' => true
    ),
    array(
        'icon' => "envelope",
        'title' => "Newsletter",
        'summary' => '<div id="newsletter-number"></div>',
        'link' => 'newsletter',
        'target' => "",
        'sidebar' => true,
        'status' => true,
        'index' => true,
        'onlyadmin' => true
    ),
    array(
        'icon' => "bar-chart-line",
        'title' => "Statistiche",
        'summary' => '<div id="last-stats"></div>',
        'link' => 'stats',
        'target' => "",
        'sidebar' => true,
        'status' => true,
        'index' => true,
        'onlyadmin' => true
    ),
    array(
        'icon' => "people",
        'title' => "Utenti",
        'summary' => '<div id="user-number"></div>',
        'link' => 'users',
        'target' => "",
        'sidebar' => true,
        'status' => true,
        'index' => true,
        'onlyadmin' => true
    ),
    array(
        'icon' => "question-square",
        'title' => "Help",
        'summary' => "",
        'link' => "#",
        'target' => "",
        'sidebar' => true,
        'status' => false,
        'index' => true,
        'onlyadmin' => false
    ),
    array(
        'icon' => "door-open",
        'title' => "Logout",
        'summary' => "",
        'link' => InternetFile('logout', true),
        'target' => "",
        'sidebar' => true,
        'status' => true,
        'index' => true,
        'onlyadmin' => false
    )
];
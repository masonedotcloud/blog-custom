<?php
/*
    site.php
    Gestione delle impostazioni generali del sito
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Author();
//ritorno del logo
if (isset($_GET['logo'])) {
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch = mysqli_fetch_array($result);
        $logo = InternetFIle("public/assets/site/" . $fetch['image'], true);
    }
    $Alert->Custom($logo);
}
//dati sulle categorie
if (isset($_GET['category-number'])) {
    $sql = "SELECT * FROM category WHERE 1";
    $result = mysqli_query($conn, $sql);
    $text = "";
    if ($result) {
        $text = mysqli_num_rows($result);
    } else {
        $text = "0";
    }
    $text .= " Categorie<br>";
    $sql = "SELECT * FROM category WHERE status = 1 AND parent -1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $text .= mysqli_num_rows($result);
        $text .= ' Attive <input onclick="return false;" class="form-check-input bg-success" type="radio">';
    } else {
        $text .= "0";
        $text .= ' Attive <input onclick="return false;" class="form-check-input bg-danger" type="radio">';
    }
    $Alert->Custom($text);
}
//dati delle newsletter
if (isset($_GET['newsletter-number'])) {
    $sql = "SELECT * FROM newsletter WHERE 1";
    $result = mysqli_query($conn, $sql);
    $text = "";
    if ($result) {
        $text = mysqli_num_rows($result);
    } else {
        $text = "0";
    }
    $text .= " Iscritti";
    $Alert->Custom($text);
}
//dati sugli utenti
if (isset($_GET['user-number'])) {
    $sql = "SELECT * FROM users WHERE 1";
    $result = mysqli_query($conn, $sql);
    $text = "";
    if ($result) {
        $text = mysqli_num_rows($result);
    } else {
        $text = "0";
    }
    $text .= " Iscritti";
    $Alert->Custom($text);
}
//dati sulle impostazioni del sito
if (isset($_GET['site-status'])) {
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch = mysqli_fetch_array($result);
        $text = "Login ";
        if ($fetch['login'] == 1) {
            $text .= 'attivo <input onclick="return false;" class="form-check-input bg-success" type="radio">';
        } else {
            $text .= 'disattivato <input onclick="return false;" class="form-check-input bg-danger" type="radio">';
        }
        $text .= "<br>Registrazioni ";
        if ($fetch['register'] == 1) {
            $text .= 'attive <input onclick="return false;" class="form-check-input bg-success" type="radio">';
        } else {
            $text .= 'disattivate <input onclick="return false;" class="form-check-input bg-danger" type="radio">';
        }
        $text .= "<br>Posts ";
        if ($fetch['posts'] == 1) {
            $text .= 'attivi <input onclick="return false;" class="form-check-input bg-success" type="radio">';
        } else {
            $text .= 'disattivati <input onclick="return false;" class="form-check-input bg-danger" type="radio">';
        }
        $Alert->Custom($text);
    } else {
        $Alert->Error("Errore con il server");
    }
}
//dati suelle statistiche del sito
if (isset($_GET['site-stats'])) {
    $text = "Visite oggi ";
    $date = date("Y-m-d");
    $sql = "SELECT * FROM stats WHERE date= " . "\"$date\" AND type = 'access'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $text .= mysqli_num_rows($result);
    } else {
        $text .= "0";
    }
    $Alert->Custom($text);
}
//dati sui posts
if (isset($_GET['posts-number'])) {
    $sql = "SELECT * FROM posts WHERE 1";
    $result = mysqli_query($conn, $sql);
    $text = "";
    if ($result) {
        $text .= mysqli_num_rows($result);
        $text .= " posts";
    } else {
        $text .= "0";
        $text .= " post";
    }
    $text .= "<br>";
    $sql = 'SELECT e.*, m.username AS author_username, c.name AS category_name, s.status AS category_status, u.status AS author_status, u.type AS author_type FROM posts e LEFT JOIN users m ON e.author = m.id LEFT JOIN category c ON e.category = c.id LEFT JOIN category s ON e.category = s.id LEFT JOIN users u ON e.author = u.id WHERE e.status <> "0" AND s.status <> "0" AND u.status <> "2" AND u.status <> "0" AND u.type <> "1"';
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $text .= mysqli_num_rows($result);
        $sql = "SELECT * FROM site WHERE 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $fetch = mysqli_fetch_array($result);
            if ($fetch['posts'] == 0) {
                $text .= ' Attivi <input onclick="return false;" class="form-check-input bg-warning" type="radio">';
            } else {
                $text .= ' Attivi <input onclick="return false;" class="form-check-input bg-success" type="radio">';
            }
        }
    } else {
        $text .= "0";
        $text .= ' Attivi <input onclick="return false;" class="form-check-input bg-danger" type="radio">';
    }
    $Alert->Custom($text);
}
if (isset($_GET['ciao'])) {
    $output = "Ciao anche a te<br> " . $_SESSION['username'];
    $Alert->Custom($output);
}
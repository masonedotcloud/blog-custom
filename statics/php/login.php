<?php
/*
    login.php
    Logica di base della pagina di login, contorllo delle credenziali
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
//controllo per il login
if (isset($_GET['login'])) {
    $Account->Guest();
    //dati del form
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = (isset($_POST['remember']) ? true : false);
    //validazione input
    if (empty($email) || empty($password)) {
        $Alert->Info('Email o password mancante');
    }
    if (!check_email($email)) {
        $Alert->Warning("Email non valida");
    }
    //query di verifica presenza dell'account nel sistema
    $sql = "SELECT * FROM users WHERE email = " . "\"$email\"";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error('Errore con il server');
    }
    //errore del numero di risultati nella query
    if (mysqli_num_rows($result) == 0 || mysqli_num_rows($result) != 1) {
        $Alert->Warning('Email o password errata');
    }
    $fetch = mysqli_fetch_assoc($result);
    //controllo del login attivo
    if (!LoginStatusSite($fetch['type'])) {
        $Alert->Info("Login disabilitato");
    }
    //controllo password
    if (md5($password) !== $fetch['password']) {
        $Alert->Warning('Email o password errata');
    }
    //presa dei dati e successo nel login
    $_SESSION = $fetch;
    if ($remember == true) {
        setcookie("remember", 'active', time() + (10 * 365 * 24 * 60 * 60), '/');
        $Cake->Imposta(true);
    }
    $Alert->Custom('login-success');
}

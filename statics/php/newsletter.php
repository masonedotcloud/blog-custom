<?php
/*
    newsletter.php
    Logica di base della newsletter pubblica aggiunta ed eliminazione
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
//aggiunta alla newsletter
if (isset($_GET['add'])) {
    $Account->Open();
    //presa dei dati
    $email = trim($_POST['email']);
    //validazione dei dati
    if (empty($email)) {
        $Alert->Warning("Email Vuota");
    }
    if (strlen($email) > 255) {
        $Alert->Warning("Email Troppo lunga");
    }
    //query per il controllo
    $sql = "SELECT * FROM newsletter WHERE email = " . "\"$email\"";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    //errore del numero di risultati nella query
    if (mysqli_num_rows($result) != 0 || mysqli_num_rows($result) != 1) {
        $Alert->Error('Errore con il server');
    }
    //incremento degli iscritti alla newsletter
    NewsletterAdd();
    //email gia presente
    if (mysqli_num_rows($result) == 1) {
        $Alert->Custom("success");
    }
    //inserimento dell'email
    $uni_code = md5(milliseconds() . $email);
    $sql = "INSERT INTO newsletter (email, uni_code) VALUES (" . "\"$email\""  . ", " . "\"$uni_code\"" . ")";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    $Alert->Custom("success");
}
//eliminazione dalla newsletter
if (isset($_GET['delete'])) {
    $Account->Open();
    $uni_code = $_GET['delete'];
    $sql = "DELETE FROM newsletter WHERE uni_code = " . "\"$uni_code\"";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $Alert->Custom("Account eliminato con successo");
    } else {
        $Alert->Custom("Errore durante l'eliminazione");
    }
}

<?php
/*
    code.php
    logica di base sulla pagina di verifica dell'account con il codice
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
//codice per il controllo del codice inserito
if (isset($_GET['check'])) {
    $Account->Code();
    //presa dei dati dal form
    $code = trim($_POST['code']);
    $id = $_SESSION['id'];
    //controllo presenza dei dati
    if (empty($code)) {
        $Alert->Info("Codice non inserito");
    }
    //query del codice
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error('Errore con il server');
    }
    //errore del numero di risultati nella query
    if (mysqli_num_rows($result) != 1) {
        $Alert->Error('Errore con il server');
    }
    //controllo del codice
    $fetch = mysqli_fetch_assoc($result);
    if ($fetch['code'] != $code) {
        $Alert->Error("Codice non valido");
    }
    //update status dell'account
    $sql = "UPDATE users SET status = 1, code = null WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error('Errore con il server');
    }
    //aggiornamento della sessione
    $_SESSION['status'] = 1;
    //aggiornamento dei cookie
    $Cake->Imposta();
    $Alert->Custom("code-success");
}

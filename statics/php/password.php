<?php
/*
    password.php
    controlli sulla password dimenticata e relativa richiesta
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
function send_reset_password($code)
{
    //email per la richiesta di password dimenticata
    return true;
}
//selezione e creazione della richiesta
if (isset($_GET['email'])) {
    $Account->Guest();
    //controllo se è stata fatta una richiesta nell'ultimo minuto
    if (isset($_SESSION['last_send_password'])) {
        $date = Difference_Date(date("Y-m-d H:i:s"), $_SESSION['last_send_password']);
        if ($date['minuts'] < 1) {
            $Alert->Warning('Devi attendere ' . (60 - intval($date['seconds'])) . ' secondi per un\' altra richiesta');
        }
    }
    //salvataggio dell'orario della richiesta
    $_SESSION['last_send_password'] = date("Y-m-d H:i:s");
    //presa dei dati del form
    $email = trim($_POST['email']);
    //validazione input
    if (empty($email)) {
        $Alert->Info("L'email non può essere vuota");
    }
    if (!check_email($email)) {
        $Alert->Warning("Email non valida");
    }
    //controllo presenza dell'email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    //presenza di una sola email
    if (mysqli_num_rows($result) != 1) {
        $Alert->Error('Errore con il server');
    }
    //presa di alcuni dati per la generazione di un codice univoco
    $fetch = mysqli_fetch_assoc($result);
    $reset_unic_code = md5(md5($fetch['email']) . md5($fetch['name'] . md5(milliseconds())) . md5(md5($fetch['email']) . md5($fetch['surname'] . md5(milliseconds()))));
    $sql = "UPDATE users SET reset_password_otp = '$reset_unic_code' WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    //invio dell'email
    $result = send_reset_password($reset_unic_code);
    if (!$result) {
        $sql = "UPDATE users SET reset_password_otp = NULL " . "WHERE reset_password_otp =" . "\"$reset_unic_code\"";
        mysqli_query($conn, $sql);
        $Alert->Error("Errore nell'invio dell'email");
    }
    $Alert->Success("Email corretamente inviata all'indirizzo: " . $email);
}
//controllo del codice inserito per la modifica
if (isset($_GET['otp'])) {
    $Account->Guest();
    //presa dei dati dal form
    $otp = $_GET['otp'];
    $password = $_POST['password'];
    $password_check = $_POST['password-check'];
    //query per la presenza dell'otp
    $sql = "SELECT * FROM users WHERE reset_password_otp = '$otp'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    //presenza di una sola richiesta con quel codice
    if (mysqli_num_rows($result) != 1) {
        $Alert->Error('Errore con il server');
    }
    //validazione input
    if (empty($password)) {
        $Alert->Warning("Inserire la nuova password");
    }
    if (empty($password_check)) {
        $Alert->Warning("Confermare la nuova password");
    }
    if ($password !== $password_check) {
        $Alert->Warning("Le password non coincidono");
    }
    //aggiornamento della password
    $password_md5 = md5($password);
    $sql = "UPDATE users SET password = '$password_md5', reset_password_otp = NULL WHERE reset_password_otp = '$otp'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    $Alert->Custom("reset-success");
}

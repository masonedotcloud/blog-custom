<?php
/*
    register.php
    gestione delle registrazioni nel database
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
//richiesta di aggiunta di un nuovo profilo
if (isset($_GET['add'])) {
    $Account->Guest();
    //controllo se le registrazioni sono attive
    if (!RegisterStatusSite()) {
        $Alert->Info("Registrazioni disabilitate");
    }
    //dati dal form
    $username = trim($_POST['username']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_check = $_POST['password-check'];
    $image_name = "";
    $id = -1;
    //controlla che ci siano tutti i campi compilati
    if ((empty($username) || empty($email) || empty($password) || empty($password_check) || empty($email) || empty($surname))) {
        $Alert->Warning("Controlla di aver compilato tutti i richiesti");
    }
    //controllo le due password
    if ($password !== $password_check) {
        $Alert->Warning("Le password non coincidono");
    }
    //validazione email
    if (!check_email($email)) {
        $Alert->Warning("Email non valida");
    }
    //controllo che non l'email sia già reistata
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    if (mysqli_num_rows($result) != 0) {
        $Alert->Info('Email già presente <a href="login"><strong>accedi</strong></a>');
    }
    $password_md5 = md5($password);
    $code = code_for_verify();
    //nome dell'avatar
    if (!empty($_FILES['avatar']['name'])) {
        $file_extension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
        $allowed_image_extension = array("png", "jpg", "jpeg", "svg", "icon");
        if (in_array($file_extension, $allowed_image_extension)) {
            $path = $_FILES['avatar']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $image_name = "avatar" . milliseconds() . "." . $ext;
        } else {
            $Alert->Error("Estenzione immagine non supportata");
        }
    } else {
        $image_name = "avatar.png";
    }
    //inserimento dati nel database
    $sql = "
        INSERT INTO users(
            username,
            NAME,
            surname,
            email,
            PASSWORD,
            CODE,
            avatar
        )
        VALUES(
            '$username',
            '$name',
            '$surname',
            '$email',
            '$password_md5',
            '$code',
            '$image_name'
        )
    ";
    //controllo della query
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo $sql;
        $Alert->Error("Errore con il server");
    }
    //presa dell'id per la creazione della cartella
    $sql = "SELECT id from users where email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    if (mysqli_num_rows($result) != 1) {
        $Alert->Error("Errore con il server");
    }
    $fetch = mysqli_fetch_array($result);
    $id = $fetch['id'];
    //creazione della cartella
    $result = mkdir($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id);
    if (!$result) {
        $sql = "DELETE FROM users WHERE id = $id";
        mysqli_query($conn, $sql);
        $Alert->Error("Errore con il server");
    }
    //salvataggio dell'immagine nella cartella dell'utente
    $result = '';
    if (empty($_FILES['avatar']['name'])) {
        $result = copy($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/avatar.png", $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id . "/avatar.png");
    } else {
        $destination = $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id . "/" . $image_name;
        $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);
    }
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    //presa di tutti i dati dell'utente
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $sql = "DELETE FROM users WHERE id = $id";
        mysqli_query($conn, $sql);
        deleteAll($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id);
        $Alert->Error("Errore con il server");
    }
    //registrazione effettuata
    $fetch = mysqli_fetch_assoc($result);
    $_SESSION = $fetch;
    SubscriberAdd();
    Send_Code($_SESSION['email'], $code);
    $Alert->Custom("register-success");
}

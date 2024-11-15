<?php
/*
    session.php
    controllo che la sessione dell'utente sia idone ed abilitata ad eseguire l'acesso alle pagine
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id =" . "\"$id\"";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $fetch = mysqli_fetch_assoc($result);
            if ($fetch['id'] == $id && $fetch['status'] == 2 && isset($_GET['page']) && $_GET['page'] != "disable") {
                $_SESSION['status'] = $fetch['status'];
                $Cake->Imposta();
                $Alert->Custom(InternetFIle("disable", false));
            }
            if ($fetch['id'] == $id && $fetch['status'] == 1 && isset($_GET['page']) && ($_GET['page'] == "disable" || $_GET['page'] == "code")) {
                $_SESSION['status'] = $fetch['status'];
                $Cake->Imposta();
                $Alert->Custom(InternetFIle("index", false));
            }
            if ($fetch['id'] == $id && $fetch['status'] == 0 && isset($_GET['page']) && $_GET['page'] != "code") {
                $_SESSION['status'] = $fetch['status'];
                $Cake->Imposta();
                $Alert->Custom(InternetFIle("code", false));
            }
            if ($fetch['id'] == $id && $fetch['type'] != $_SESSION['type']) {
                $_SESSION['type'] = $fetch['type'];
                $Cake->Imposta();
                $Alert->Custom(InternetFIle("index", false));
            }
            if ($fetch['id'] == $id && $fetch['reset_password_otp'] != $_SESSION['reset_password_otp']) {
                if ($fetch['reset_password_otp'] == NULL) {
                    $_SESSION['reset_password_otp'] = "";
                } else {
                    $_SESSION['reset_password_otp'] = $fetch['reset_password_otp'];
                }
                $Cake->Imposta();
                $Alert->Custom("NULL");
            }
            if ($fetch['id'] == $id && $_SESSION['avatar'] != $fetch['avatar']) {
                $_SESSION['avatar'] = $fetch['avatar'];
                $Cake->Imposta();
                $Alert->Custom("NULL");
            }
            if ($fetch['id'] == $id && $_SESSION['name'] != $fetch['name']) {
                $_SESSION['name'] = $fetch['name'];
                $Cake->Imposta();
                $Alert->Custom("NULL");
            }
            if ($fetch['id'] == $id && $_SESSION['username'] != $fetch['username']) {
                $_SESSION['username'] = $fetch['username'];
                $Cake->Imposta();
                $Alert->Custom("NULL");
            }
            if ($fetch['id'] == $id && $_SESSION['surname'] != $fetch['surname']) {
                $_SESSION['surname'] = $fetch['surname'];
                $Cake->Imposta();
                $Alert->Custom("NULL");
            }
            if ($fetch['id'] == $id && $_SESSION['email'] != $fetch['email']) {
                $_SESSION['email'] = $fetch['email'];
                $Cake->Imposta();
                $Alert->Custom("NULL");
            }
            if ($fetch['id'] == $id && $_SESSION['code'] != $fetch['code']) {
                $_SESSION['code'] = $fetch['code'];
                $Cake->Imposta();
                $Alert->Custom("NULL");
            }
        } else if (mysqli_num_rows($result) == 0) {
            $Alert->Custom(InternetFIle("logout", false));
        } else {
            $Alert->Custom("NULL");
        }
    }
    if ($_SESSION['type'] != 0) {
        $sql = "SELECT * FROM site WHERE 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $fetch = mysqli_fetch_array($result);
                if ($fetch['login'] == 0) {
                    $Alert->Custom(InternetFIle("logout", false));
                } else {
                    $Alert->Custom("NULL");
                }
            } else if (mysqli_num_rows($result) == 0) {
                $Alert->Custom(InternetFIle("logout", false));
            } else {
                $Alert->Custom("NULL");
            }
        } else {
            $Alert->Custom("NULL");
        }
    } else {
        $Alert->Custom("NULL");
    }
} else {
    $Alert->Custom("NULL");
}

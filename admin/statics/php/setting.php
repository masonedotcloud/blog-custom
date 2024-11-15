<?php
/*
    setting.php
    Gestione delle attività della pagina di setting
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Admin();
//ripempimento con i dati del sito
if (isset($_GET['fill_data'])) {
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $Alert->Custom(json_encode($data));
    }
}
//get del debug
if (isset($_GET['get_debug'])) {
    if (isset($_SESSION['debug'])) {
        echo $_SESSION['debug'];
    } else {
        echo 'false';
    }
}
//aggiornamento delle impostazioni
if (isset($_GET['update'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phrase = trim($_POST['phrase']);
    $description = trim($_POST['description']);
    $image_name = "";
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch = mysqli_fetch_assoc($result);
    } else {
        $Alert->Error("Errore con il server");
    }
    $do_query = false;
    $sql = "UPDATE site SET ";
    if (!empty($name)) {
        if ($name != $fetch['name']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "name = \"$name\"";
        }
    } else {
        $Alert->Warning("Il nome non può essere vuoto");
    }
    if (!empty($email)) {
        if ($email != $fetch['email']) {
            if (!check_email($email)) {
                $Alert->Warning("Email non valida");
            }
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "email = \"$email\"";
        }
    } else {
        $Alert->Warning("L'email non può essere vuota");
    }
    if (!empty($description)) {
        if ($description != $fetch['description']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "description = \"$description\"";
        }
    } else {
        $Alert->Warning("La descrizione non può essere vuota");
    }
        if ($phrase != $fetch['phrase']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "phrase = \"$phrase\"";
        }
    if (!empty($description)) {
        if ($description != $fetch['description']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "description = \"$description\"";
        }
    }
    if (!empty($_FILES['image']['name'])) {
        $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $allowed_image_extension = array("png", "jpg", "jpeg", "svg", "icon");
        if (in_array($file_extension, $allowed_image_extension)) {
            $path = $_FILES['image']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $image_name = "favicon" . milliseconds() . "." . $ext;
            $destination = $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/site/" . $image_name;
            $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            if ($result) {
                $do_query = true;
                if (str_contains($sql, "=")) {
                    $sql .= ", ";
                }
                $sql .= "image = \"$image_name\"";
            } else {
                $Alert->Error("Errore nel caricamento dell'immagine");
            }
        } else {
            $Alert->Warning("Estenzione dell'immagine non supportata");
        }
    }
    if ($do_query) {
        $image_name_old = "";
        if ($image_name != "") {
            $sql_old_image = "SELECT * FROM site WHERE 1";
            $result = mysqli_query($conn, $sql_old_image);
            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    $result = mysqli_fetch_array($result);
                    $image_name_old = $result['image'];
                } else {
                    $Alert->Error("Errore con il server");
                }
            } else {
                $Alert->Error("Errore con il server");
            }
        }
        $sql .= " WHERE 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if ($image_name != "") {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/site/" . $image_name_old);
            }
        } else {
            $Alert->Error("Errore con il server");
        }
    }
    $Alert->Success("Dati aggiornati");
}
//attiva o disattiva login
if (isset($_GET['login'])) {
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch = mysqli_fetch_array($result);
        if ($fetch['login'] == 0) {
            $sql = "UPDATE site SET login = 1 WHERE 1";
            $result = mysqli_query($conn, $sql);
            if ($result) {
            } else {
                $Alert->Error("Errore con il server");
            }
        } else {
            $sql = "UPDATE site SET login = 0 WHERE 1";
            $result = mysqli_query($conn, $sql);
            if ($result) {
            } else {
                $Alert->Error("Errore con il server");
            }
        }
    }
}
//attiva o disattiva reistrazioni
if (isset($_GET['register'])) {
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch = mysqli_fetch_array($result);
        if ($fetch['register'] == 0) {
            $sql = "UPDATE site SET register = 1 WHERE 1";
            $result = mysqli_query($conn, $sql);
            if ($result) {
            } else {
                $Alert->Error("Errore con il server");
            }
        } else {
            $sql = "UPDATE site SET register = 0 WHERE 1";
            $result = mysqli_query($conn, $sql);
            if ($result) {
            } else {
                $Alert->Error("Errore con il server");
            }
        }
    }
}
//attiva o disattiva la visualizzazione dei posts
if (isset($_GET['posts'])) {
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch = mysqli_fetch_array($result);
        if ($fetch['posts'] == 0) {
            $sql = "UPDATE site SET posts = 1 WHERE 1";
            $result = mysqli_query($conn, $sql);
            if ($result) {
            } else {
                $Alert->Error("Errore con il server");
            }
        } else {
            $sql = "UPDATE site SET posts = 0 WHERE 1";
            $result = mysqli_query($conn, $sql);
            if ($result) {
            } else {
                $Alert->Error("Errore con il server");
            }
        }
    }
}
//attiva disattiva debug
if (isset($_GET['debug'])) {
    if (isset($_SESSION['debug'])) {
        if ($_SESSION['debug'] == 'true') {
            $_SESSION['debug'] = 'false';
        } else {
            $_SESSION['debug'] = 'true';
        }
    } else {
        $_SESSION['debug'] = 'false';
    }
}
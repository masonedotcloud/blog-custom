<?php
/*
    users.php
    Parte logica della visualizzazione della pagina
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Admin();
//modifica dello stato attraverso le frecce
if (isset($_GET['direction']) && isset($_GET['option']) && isset($_GET['id'])) {
    $direction = $_GET['direction'];
    $option = $_GET['option'];
    $id = $_GET['id'];
    $output = "";
    $sql = "SELECT * FROM users WHERE id = \"$id\"";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $fetch = mysqli_fetch_array($result);
            //modifica dello stato altrimenti modifica del tipo
            if ($option == 'status') {
                $status = $fetch['status'];
                if ($direction == 'left') {
                    if (($fetch['status'] - 1) < 0) {
                        $status = 2;
                    } else {
                        $status--;
                    }
                } else if ($direction == 'right') {
                    if (($fetch['status'] + 1) > 2) {
                        $status = 0;
                    } else {
                        $status++;
                    }
                }
                $sql = "UPDATE users SET status = " . $status . " WHERE id = \"$id\"";
                if ($status == 0) {
                    $output = ' Non verificato ';
                }
                if ($status == 1) {
                    $output = ' Attivo ';
                }
                if ($status == 2) {
                    $output = ' Disattivato ';
                }
            } else if ($option == 'type') {
                $type = $fetch['type'];
                if ($direction == 'left') {
                    if (($fetch['type'] - 1) < 0) {
                        $type = 2;
                    } else {
                        $type--;
                    }
                } else if ($direction == 'right') {
                    if (($fetch['type'] + 1) > 2) {
                        $type = 0;
                    } else {
                        $type++;
                    }
                }
                $sql = "UPDATE users SET type = " . $type . " WHERE id = \"$id\"";
                if ($type == 0) {
                    $output = ' Admin ';
                }
                if ($type == 1) {
                    $output = ' Utente ';
                }
                if ($type == 2) {
                    $output = ' Autore ';
                }
            }
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $Alert->Custom($output);
            } else {
                $Alert->Error("Errore con il server");
            }
        } else {
            $Alert->Error("Errore con il server");
        }
    } else {
        $Alert->Error("Errore con il server");
    }
}
//elimina utente
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = 'UPDATE posts SET author = "-1" WHERE author = ' . $id;
    $result = mysqli_query($conn, $sql);
    $sql = "DELETE FROM users WHERE id =" . "\"$id\"";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        deleteAll($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id);
        $Alert->Success("Account eliminato con successo");
    } else {
        $Alert->Error("Errore con il server");
    }
}
//ritorno dati di un utente
if (isset($_GET['get'])) {
    $id = $_GET['get'];
    $sql = "SELECT * FROM users WHERE id = " . "\"$id\"";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);
    echo json_encode($data);
}
//dispplay degli utenti
if (isset($_GET['search'])) {
    $limit = '12';
    $page = 1;
    if (isset($_POST['page'])) {
        if ($_POST['page'] > 1) {
            $start = (($_POST['page'] - 1) * $limit);
            $page = $_POST['page'];
        } else {
            $start = 0;
        }
    } else {
        $start = 0;
        $page = 1;
    }
    $query = "SELECT * FROM users ";
    if ($_POST['query'] != '') {
            $query .= 'WHERE ' . $_POST['column'] . ' LIKE "%' . str_replace(' ', '%', $_POST['query']) . '%" ';
        if (!empty($_POST['only'])) {
            $query .= ' AND ' . $_POST['only'];
        }
        $query .= ' AND id <> ' . $_SESSION['id'];
    } else {
        if (!empty($_POST['only'])) {
            $query .= ' WHERE ' . $_POST['only'];
            $query .= ' AND id <> ' . $_SESSION['id'];
        } else {
            $query .= ' WHERE id <> ' . $_SESSION['id'];
        }
    }
    $query .= ' ORDER BY ' . $_POST['column'] . ' ' . $_POST['order'] . ' ';
    $filter_query = $query . 'LIMIT ' . $start . ', ' . $limit . '';
    //eseguzioni delle query con contorllo
    $statement = mysqli_query($conn, $query);
    if (!$statement) {
        $output = '
            <div class="alert alert-danger p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Errore nella ricerca
            </div>
        ';
        $Alert->Custom($output);
    }
    $result = mysqli_query($conn, $filter_query);
    if (!$result) {
        $output = '
            <div class="alert alert-danger p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Errore nella ricerca
            </div>
        ';
        $Alert->Custom($output);
    }
    $total_data = mysqli_num_rows($statement);
    $total_filter_data = mysqli_num_rows($statement);
    $output = '';
    if ($total_data > 0) {
        $num_card = 0;
        while ($row = mysqli_fetch_array($result)) {
            $num_card++;
            $type = '';
            if ($row['type'] == 0) {
                $type = ' Admin ';
            }
            if ($row['type'] == 1) {
                $type = ' Utente ';
            }
            if ($row['type'] == 2) {
                $type = ' Autore ';
            }
            $status = '';
            if ($row['status'] == 0) {
                $status = ' Non verificato ';
            }
            if ($row['status'] == 1) {
                $status = ' Attivo ';
            }
            if ($row['status'] == 2) {
                $status = ' Disattivato ';
            }
            $output .= '
                <div class="d-flex bg-white p-3 shadow mb-2" style="border-radius:15px;">
                    <div class="col-auto me-2">
                        <img src="' . InternetFIle('public/assets/users/' . $row['id'] . '/' . $row['avatar'], true) . '" alt="' . $row['avatar'] . '" width="65" height="65" class="rounded-circle" />
                    </div>
                    <div class="col">
                        <h4 class="m-0">' . $row['username'] . '</h4>
                        <p class="m-0">' . $row['name'] . ' ' . $row['surname'] . '</p>
                        <p class="m-0">' . $row['email'] . '</p>
                        <div>
                            <i class="bi bi-caret-left cursor-pointer" onclick="arrow(\'left\', \'type\', \'' . $row['id'] . '\')"></i>
                            <span onclick="arrow(\'right\', \'type\', \'' . $row['id'] . '\')" id="account_type_' . $row['id'] . '">' . $type . '</span>
                            <i class="bi bi-caret-right cursor-pointer" onclick="arrow(\'right\', \'type\', \'' . $row['id'] . '\')"></i>
                        </div>
                        <div>
                            <i class="bi bi-caret-left cursor-pointer" onclick="arrow(\'left\', \'status\', \'' . $row['id'] . '\')"></i>
                            <span onclick="arrow(\'right\', \'status\', \'' . $row['id'] . '\')" id="account_status_' . $row['id'] . '">' . $status . '</span>
                            <i class="bi bi-caret-right cursor-pointer" onclick="arrow(\'right\', \'status\', \'' . $row['id'] . '\')"></i>
                        </div>
                    </div>
                    <div class="col-auto me-3">
                        <div class="row mb-2">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit" onclick="modal_edit(' . $row['id'] . ')">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-' . $row['id'] . '">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="modal-delete-' . $row['id'] . '" tabindex="-1" aria-labelledby="modal-delete-' . $row['id'] . '" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-delete-' . $row['id'] . '">Eliminare l\'account?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                L\'azione è irreversibile, sei sicuro di voler eliminare l\'account ' . $row['email'] . '?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <button type="submit" onclick="delete_user(' .  $row['id'] . ')" data-bs-dismiss="modal" class="btn btn-danger">Elimina</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
        $output .= ($num_card == 1) ? ('</div id="one-card"></div>') : ('');
        $output .= '<small class="p-0">La query ha prodotto ' . $total_data . ' risultati</small>';
        $output .= '<ul class="pagination d-flex justify-content-center mt-3">';
        $total_links = ceil($total_data / $limit);
        $previous_link = '';
        $next_link = '';
        $page_link = '';
        if ($total_links > 4) {
            if ($page < 5) {
                for ($count = 1; $count <= 5; $count++) {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            } else {
                $end_limit = $total_links - 5;
                if ($page > $end_limit) {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $end_limit; $count <= $total_links; $count++) {
                        $page_array[] = $count;
                    }
                } else {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $page - 1; $count <= $page + 1; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        } else {
            for ($count = 1; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        }
        for ($count = 0; $count < count($page_array); $count++) {
            if ($page == $page_array[$count]) {
                $page_link .= '
                    <li class="page-item active">
                        <a class="page-link" href="javascript: void(0)">' . $page_array[$count] . ' <span class="sr-only"></span></a>
                    </li>
                ';
                $previous_id = $page_array[$count] - 1;
                if ($previous_id > 0) {
                    $previous_link = '
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-page_number="' . $previous_id . '">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    ';
                } else {
                    $previous_link = '
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript: void(0)">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    ';
                }
                $next_id = $page_array[$count] + 1;
                if ($next_id > $total_links) {
                    $next_link = '
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript: void(0)">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    ';
                } else {
                    $next_link = '
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-page_number="' . $next_id . '">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    ';
                }
            } else {
                if ($page_array[$count] == '...') {
                    $page_link .= '
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript: void(0)">...</a>
                        </li>
                    ';
                } else {
                    $page_link .= '
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '</a>
                        </li>
                    ';
                }
            }
        }
        $output .= $previous_link . $page_link . $next_link;
        $output .= '</ul>';
        $Alert->Custom($output);
    } else {
        $output = '
            <div class="alert alert-warning" role="alert">
                Nessun utente trovato, a si tu non vieni calcolato se vuoi essere calcolato <a class="link-primary cursor-pointer text-decoration-none" href="' .InternetFIle('profile', true).'"><strong>clicca qui</strong></a>
            </div>
        ';
        $Alert->Custom($output);
    }
}
//modifica di un utente
if (isset($_GET['edit'])) {
    $id = trim($_POST['id']);
    $username = trim($_POST['username']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $image_name = "";
    $do_query = false;
    $sql = "SELECT * FROM users WHERE id = \"$id\"";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    } else {
        if (mysqli_num_rows($result) != 1) {
            $Alert->Error("Errore con il server");
        } else {
            $fetch = mysqli_fetch_array($result);
        }
    }
    $sql = "UPDATE users SET ";
    //controllo email
    if (!empty($email)) {
        if (check_email($email)) {
            $Alert->Warning("Email non valida");
        }
        if ($email != $fetch['email']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "email = \"$email\"";
        }
    } else {
        $Alert->Warning("L'email non può essere vuota");
    }
    //controllo username
    if (!empty($username)) {
        if ($username != $fetch['username']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "username = \"$username\"";
        }
    } else {
        $Alert->Warning("L'username non può essere vuoto");
    }
    //contorollo nome
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
    //contorllo cognome
    if (!empty($surname)) {
        if ($surname != $fetch['surname']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "surname = \"$surname\"";
        }
    } else {
        $Alert->Warning("Il cognome non può essere vuoto");
    }
    //controllo avatar
    if (!empty($_FILES['avatar']['name'])) {
        $file_extension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
        $allowed_image_extension = array("png", "jpg", "jpeg", "svg", "icon");
        if (in_array($file_extension, $allowed_image_extension)) {
            $path = $_FILES['avatar']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $image_name = "avatar" . milliseconds() . "." . $ext;
            $destination = $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id . "/" . $image_name;
            $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);
            if ($result) {
                $do_query = true;
                if (str_contains($sql, "=")) {
                    $sql .= ", ";
                }
                $sql .= "avatar = \"$image_name\"";
            } else {
                $Alert->Error("Errore nel caricamento dell'immagine");
            }
        } else {
            $Alert->Warning("Estenzione dell'immagine non supportata");
        }
    }
    //controllo per applicre le modifiche
    if ($do_query) {
        $image_name_old = "";
        if ($image_name != "") {
            $sql_old_image = "SELECT * FROM users WHERE id =" . "\"$id\"";
            $result = mysqli_query($conn, $sql_old_image);
            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    $result = mysqli_fetch_array($result);
                    $image_name_old = $result['avatar'];
                } else {
                    $Alert->Error("Errore con il server");
                }
            } else {
                $Alert->Error("Errore con il server");
            }
        }
        $sql .= " WHERE id = \"$id\"";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql = "SELECT * FROM users WHERE id =" . "\"$id\"";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $fetch = mysqli_fetch_assoc($result);
                if ($image_name != "") {
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id . "/" . $image_name_old);
                }
            } else {
                $Alert->Error("Errore con il server");
            }
        } else {
            $Alert->Error("Errore con il server");
        }
    }
    $Alert->Success("Dati aggiornati");
}
//aggiunti di un utente
if (isset($_GET['add'])) {
    $username = trim($_POST['username']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_check = $_POST['password-check'];
    $image_name = "";
    $id = -1;
    if (!(empty($username) || empty($email) || empty($password) || empty($password_check) || empty($email) || empty($surname))) {
        if (check_email($email)) {
            $Alert->Warning("L'email non è valida");
        }
        if ($password === $password_check) {
            $sql = "SELECT * FROM users WHERE email =" . "\"$email\"";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                if (mysqli_num_rows($result) == 0) {
                    $password_md5 = md5($password);
                    if (isset($_POST['type-account'])) {
                        $type = $_POST['type-account'];
                    } else {
                        $type = 1;
                    }
                    if (isset($_POST['status-account'])) {
                        $status = $_POST['status-account'];
                    } else {
                        $status = 2;
                    }
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
                    $sql = "INSERT INTO users (username, name, surname, email, password, status, type, avatar) VALUES (" . "\"$username\"" . ", " . "\"$name\"" . ", " . "\"$surname\"" . ", " . "\"$email\"" . ", " . "\"$password_md5\"" . ", " . "\"$status\"" . ", " . "\"$type\"" . ", " . "\"$image_name\"" . ")";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        $sql = "SELECT * FROM users WHERE email =" . "\"$email\"";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            $fetch = mysqli_fetch_assoc($result);
                            $id = $fetch['id'];
                            $result = mkdir($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id);
                            if ($result) {
                                if (empty($_FILES['avatar']['name'])) {
                                    $result = copy($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/avatar.png", $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id . "/avatar.png");
                                    if ($result) {
                                        SubscriberAdd();
                                        $Alert->Success("Account creato");
                                    } else {
                                        $sql = "DELETE FROM users WHERE email=" . "\"$email\"";
                                        if ($result) {
                                            $Alert->Error("Errore nel caricamento dell'avatar");
                                        } else {
                                            $Alert->Error("Errore con il server");
                                        }
                                    }
                                } else {
                                    $destination = $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id . "/" . $image_name;
                                    $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);
                                    if ($result) {
                                        SubscriberAdd();
                                        $Alert->Success("Account creato");
                                    } else {
                                        $sql = "DELETE FROM users WHERE email=" . "\"$email\"";
                                        if ($result) {
                                            $Alert->Error("Errore nel caricamento dell'avatar");
                                        } else {
                                            $Alert->Error("Errore con il server");
                                        }
                                    }
                                }
                            } else {
                                $sql = "DELETE FROM users WHERE email=" . "\"$email\"";
                                if ($result) {
                                    $Alert->Error("Errore nella creazione del profilo");
                                } else {
                                    $Alert->Error("Errore con il server");
                                }
                            }
                        } else {
                            $sql = "DELETE FROM users WHERE email=" . "\"$email\"";
                            if ($result) {
                                $Alert->Error("Errore con il server");
                            } else {
                                $Alert->Error("Errore con il server");
                            }
                        }
                    } else {
                        $Alert->Error("Errore con il server");
                    }
                } else if (mysqli_num_rows($result) == 1) {
                    $Alert->Info("Email già registrata");
                } else {
                    $Alert->Error("Errore nella ricerca dell'email");
                }
            } else {
                $Alert->Error("Errore con il server");
            }
        } else {
            $Alert->Error("Le password non coincidono");
        }
    } else {
        $Alert->Warning("Controlla di aver compilato tutti i campi");
    }
}
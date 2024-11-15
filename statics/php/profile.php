<?php
/*
    profile.php
    gestione delle preferenze del profilo e dati, gestione dei preferiti
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
//invio del codice per la verifica del cambio mail
if (isset($_GET['send_code_change_mail'])) {
    $Account->User();
    //controllo la data dell'ultima richiesta
    if (isset($_SESSION['last_send_code_mail_change'])) {
        $date = Difference_Date(date("Y-m-d H:i:s"), $_SESSION['last_send_code_mail_change']);
        if ($date['minuts'] < 1) {
            $Alert->Warning('Devi attendere ' . (60 - intval($date['seconds'])) . ' secondi prima di richiedere un nuovo codice');
        }
    }
    //salvataggio dell'orario
    $_SESSION['last_send_code_mail_change'] = date("Y-m-d H:i:s");
    $_SESSION['last_send_code_mail_change_code'] = code_for_verify();
    //Invio del codice per email
    $result = Send_Code($_POST['email'], $_SESSION['last_send_code_mail_change_code']);
    if ($result) {
        $Alert->Success("Codice inviato all'email " . $_POST['email']);
    } else {
        $Alert->Error("Errore nell'invio");
    }
}
//controllo del codice e dell'email
if (isset($_GET['code']) && !empty($_GET['code']) && isset($_GET['email']) && !empty($_GET['email'])) {
    $Account->User();
    //presa dei dati dal form
    $code = trim($_GET['code']);
    $email = trim($_GET['email']);
    $id = $_SESSION['id'];
    //controllo della conferma
    if ($code == $_SESSION['last_send_code_mail_change_code']) {
        $_SESSION['email-change-success'] = $email;
        $Alert->Custom("email-confirm-success");
    } else {
        $Alert->Error("Codice non valido");
    }
}
//codice vuoto
if (isset($_GET['code']) && empty($_GET['code'])) {
    $Account->User();
    $Alert->Warning("Codice non inserito");
}
//ritorno dell'email della sessione
if (isset($_GET['email'])) {
    $Account->User();
    $Alert->Custom($_SESSION['email']);
}
//modifica del profilo
if (isset($_GET['edit'])) {
    $Account->User();
    //presa dati dal form
    $username = trim($_POST['username']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $old_password = $_POST['password-old'];
    $password = $_POST['password'];
    $password_check = $_POST['password-check'];
    $image_name = "";
    $id = $_SESSION['id'];
    $do_query = false;
    $sql = "UPDATE users SET ";
    //validazione email
    if (!empty($email)) {
        if ($email != $_SESSION['email']) {
            if (isset($_SESSION['email-change-success']) && $email == $_SESSION['email-change-success']) {
                $do_query = true;
                if (str_contains($sql, "=")) {
                    $sql .= ", ";
                }
                $sql .= "email = \"$email\"";
                unset($_SESSION['email-change-success']);
            } else {
                $Alert->Warning("L'email deve esssere confermata");
            }
        }
    } else {
        $Alert->Warning("L'email non può essere vuota");
    }
    //validazione dell'username
    if (!empty($username)) {
        if ($username != $_SESSION['username']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "username = \"$username\"";
        }
    } else {
        $Alert->Warning("L'username non può essere vuoto");
    }
    //validazione del nome
    if (!empty($name)) {
        if ($name != $_SESSION['name']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "name = \"$name\"";
        }
    } else {
        $Alert->Warning("Il nome non può essere vuoto");
    }
    //validazione del cognome
    if (!empty($surname)) {
        if ($surname != $_SESSION['surname']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "surname = \"$surname\"";
        }
    } else {
        $Alert->Warning("Il cognome non può essere vuoto");
    }
    //controllo del cambio di password
    if (!empty($old_password)) {
        if (!empty($password) && !empty($password_check)) {
            if ($password == $password_check) {
                $sql_pass = "SELECT * FROM users WHERE id = \"$id\"";
                $result = mysqli_query($conn, $sql_pass);
                if ($result) {
                    if (mysqli_num_rows($result) == 1) {
                        $result = mysqli_fetch_array($result);
                        $db_pass = $result['password'];
                        if (md5($old_password) == $db_pass) {
                            $md5_password = md5($password);
                            $do_query = true;
                            if (str_contains($sql, "=")) {
                                $sql .= ", ";
                            }
                            $sql .= "password = \"$md5_password\"";
                        } else {
                            $Alert->Warning("La vecchia password non corrisponde");
                        }
                    } else {
                        $Alert->Error("Errore con il server");
                    }
                } else {
                    $Alert->Error("Errore con il server");
                }
            } else {
                $Alert->Warning("Le due password non corrispondono");
            }
        } else {
            $Alert->Warning("La nuova password non può essere vuota");
        }
    } else {
        if (!empty($password) || !empty($password_check)) {
            $Alert->Warning("Inserire la vecchia password");
        }
    }
    //controllo del cambio di immagine
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
    //se si deve modificare qualche impostazione
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
                $_SESSION = $fetch;
                if ($image_name != "") {
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/users/" . $id . "/" . $image_name_old);
                }
            } else {
                $Alert->Error("Errore con il server");
            }
        } else {
            $Alert->Error("Errore con il server");
        }
        $Cake->Imposta();
    }
    $Alert->Success("Dati aggiornati");
}
//eliminazione account
if (isset($_GET['delete'])) {
    $Account->User();
    $id = $_SESSION['id'];
    $sql = "UPDATE posts SET author = '-1' WHERE author = $id";
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
//eliminazione della richiesta password dimenticata
if (isset($_GET['delete_reset_password'])) {
    $Account->User();
    $id = $_SESSION['id'];
    $sql = "UPDATE users SET reset_password_otp = NULL WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['reset_password_otp'] = null;
        $Cake->Imposta();
        $Alert->Success("Richiesta eliminata con successo");
    } else {
        $Alert->Error("Errore con il server");
    }
}
//liminazione di un aricolo preferito
if (isset($_GET['favorites_delete']) && !empty($_GET['favorites_delete'])) {
    $Account->User();
    $old = $_SESSION['favorites'];
    $new = str_replace($_GET['favorites_delete'] . ';', '', $old);
    $sql = 'UPDATE users SET favorites="' . $new . '" WHERE id = ' . $_SESSION['id'];
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['favorites'] = $new;
        $Alert->Success("Preferito eliminato con successo");
    } else {
        $Alert->Error("Preferito non rimosso");
    }
}
//aggiunta di un articolo ai prefertio
if (isset($_GET['favorites_add']) && !empty($_GET['favorites_add'])) {
    $Account->User();
    $old = $_SESSION['favorites'];
    $new = $old . $_GET['favorites_add'] . ';';
    $sql = 'UPDATE users SET favorites="' . $new . '" WHERE id = ' . $_SESSION['id'];
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['favorites'] = $new;
        $Alert->Success("Preferito aggiunto con successo");
    } else {
        $Alert->Error("Preferito non aggiunto");
    }
}
//ritorno della lista dei preferiti
if (isset($_GET['favorites_list'])) {
    if (!PoststatusSite()) {
        $output = '
            <div class="alert alert-info p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Visualizzazione dei post e delle categorie disabilitata
            </div>
        ';
        $Alert->Custom($output);
    }
    $Account->User();
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
    //query di ricerca
    $query = '
        SELECT
            e.*,
            m.username AS author_username,
            c.name AS category_name,
            c.id AS category_id,
            s.status AS category_status,
            u.status AS author_status,
            u.type AS author_type
        FROM
            posts e
        LEFT JOIN users m ON
            e.author = m.id
        LEFT JOIN category c ON
            e.category = c.id
        LEFT JOIN category s ON
            e.category = s.id
        LEFT JOIN users u ON
            e.author = u.id
        WHERE 
            u.status = 1 AND s.status = 1 AND u.type <> 2
    ';
    $tok = strtok($_SESSION['favorites'], ";");
    $temp_string = '';
    //paragone dei preferiti salvati nell'account
    while ($tok !== false) {
        if ($temp_string == '') {
            $temp_string .= ' AND e.id in ("'.$tok.'")';
        } else {
            $temp_string .= ' OR e.id in ("'.$tok.'")';
        }
        $tok = strtok(";");
    }
    if ($temp_string == '') {
        $query .= ' AND e.id in (" ") ';
    }
    $query .= $temp_string;
    //barra di ricerca con dei valori
    if ($_POST['query'] != '') {
        $query .= ' AND ' . '(title' . ' LIKE "%' . str_replace(' ', '%', str_replace('"', '\"', $_POST['query'])) . '%" OR ' . 'content' . ' LIKE "%' . str_replace(' ', '%', str_replace('"', '\"', $_POST['query'])) . '%") ';
    }
    $query .= '
        ORDER BY
            e.date
        DESC
    ';
    $filter_query = $query . 'LIMIT ' . $start . ', ' . $limit . '';
    $statement = mysqli_query($conn, $query);
    //esecuzione delle query
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
    //se i preferiti sono maggiori di 0
    if ($total_data > 0) {
        $output = '<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5" id="grid">';
        while ($row = mysqli_fetch_array($result)) {
            if (str_contains($_SESSION['favorites'], $row['id'] . ';')) {
                $output .= '
                    <div class="col mb-3">
                        <div class="card">
                        <span class="position-absolute top-0 start-100 translate-middle cursor-pointer" id="favorite-' . $row['id'] . '" onclick="delete_favorite(' . $row['id'] . ', \'info\')">
                                <i class="bi bi-star-fill text-warning" style="font-size: 1.5rem;"></i>
                            </span>
                            <img src="' . InternetFIle('public/assets/posts/' . $row['id'] . '/' . $row['cover'], true) . '" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['title'] . '</h5>
                                <p class="card-text">' . limit_text(Strip_tags($row['content']), 20) . '</p>
                                <div>
                                    <i class="bi bi-bookmark me-1"></i>
                                    <a class="text-decoration-none" href="index?category=' . $row['category_id'] . '">' . $row['category_name'] . '</a>
                                </div>
                                <div>
                                    <i class="bi bi-calendar-week me-1"></i>
                                    ' . $row['date'] . '
                                </div>
                                <div>
                                    <i class="bi bi-person me-1"></i>
                                    ' . $row['author_username'] . '
                                </div>
                                <a href="post?view=' . $row['id'] . '" class="btn btn-primary mt-2">Visualizza</a>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        $output .= '</div>';
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
            <div class="alert alert-info p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Nessun preferito trovato
            </div>
        ';
        $Alert->Custom($output);
    }
}

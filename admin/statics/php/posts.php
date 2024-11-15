<?php
/*
    posts.php
    Gestione delle modifiche con il database
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Author();
//ritorno id della sessione
if (isset($_GET['get_session_id'])) {
    echo $_SESSION['id'];
}
//ritorno lista di autori dispopnibili per i post
if (isset($_GET['option_author'])) {
    $sql = "SELECT * FROM users WHERE type <> 1 AND status = 1 ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    $total_data = mysqli_num_rows($result);
    $output = '';
    if ($total_data > 0) {
        while ($row = MySQLi_fetch_array($result)) {
            $output .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
    $Alert->Custom($output);
}
//lista categorie disponibili comprese quelle figlio
if (isset($_GET['option_category'])) {
    $sql = '
        SELECT
        e.*,
        COUNT(p.id) AS count_post
        FROM
            category e
        LEFT JOIN posts p ON
            e.id = p.category
        WHERE
            e.status = "1" AND e.parent = "-1"
        GROUP BY
            p.category,
            e.id
        ORDER BY e.id DESC
    ';
    $result = mysqli_query($conn, $sql);
    $total_data = mysqli_num_rows($result);
    $output = '';
    if ($total_data > 0) {
        while ($row = MySQLi_fetch_array($result)) {
            $output .= '<option value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['count_post'] . ')</option>';
            $sql2 = '
                SELECT
                e.*,
                COUNT(p.id) AS count_post
                FROM
                    category e
                LEFT JOIN posts p ON
                    e.id = p.category
                WHERE
                    e.status = "1" AND e.parent = "' . $row['id'] . '"
                GROUP BY
                    p.category,
                    e.id
                ORDER BY e.id DESC
            ';
            $result2 = mysqli_query($conn, $sql2);
            $total_data2 = mysqli_num_rows($result);
            if ($total_data2 > 0) {
                while ($row2 = MySQLi_fetch_array($result2)) {
                    $output .= '<option value="' . $row2['id'] . '">&#160;&#160;&#160;&#160;' . $row2['name'] . ' (' . $row2['count_post'] . ')</option>';
                }
            }
        }
    }
    $Alert->Custom($output);
}
//modifica di un posts
if (isset($_GET['edit'])) {
    $id = trim($_POST['id']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content_data']);
    $content = str_replace('"', '\"', str_replace("'", "\'", $content));
    $category = $_POST['category'];
    $author = (isset($_POST['author']) ? $_POST['author'] : '');
    $status = (isset($_POST['status']) ? 1 : 0);
    $image_name = "";
    $do_query = false;
    $sql = "SELECT * FROM posts WHERE id = \"$id\"";
    //controllo connessione con il database
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
    $sql = "UPDATE posts SET ";
    //controllo titolo
    if (!empty($title)) {
        if ($title != $fetch['title']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "title = \"$title\"";
        }
    } else {
        $Alert->Warning("Il titolo non può essere vuoto");
    }
    //controllo del contenuto
    if (!empty($content)) {
        if ($content != $fetch['content']) {
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "content = \"$content\"";
        }
    } else {
        $Alert->Warning("Il contenuto non può essere vuoto");
    }
    //controllo categoria
    if ($category != $fetch['category']) {
        $check_category = 'SELECT * FROM category WHERE id = ' . $category;
        $result = mysqli_query($conn, $check_category);
        if (!$result) {
            $Alert->Error("Errore con il server");
        }
        if (mysqli_num_rows($result) != 1) {
            $Alert->Error("Errore con il server");
        }
        $do_query = true;
        if (str_contains($sql, "=")) {
            $sql .= ", ";
        }
        $sql .= "category = \"$category\"";
    }
    //controllo autore
    if (!empty($author)) {
        if ($author != $fetch['author']) {
            $check_author = 'SELECT * FROM users WHERE id = ' . $author;
            $result = mysqli_query($conn, $check_author);
            if (!$result) {
                $Alert->Error("Errore con il server");
            }
            if (mysqli_num_rows($result) != 1) {
                $Alert->Error("Errore con il server");
            }
            $do_query = true;
            if (str_contains($sql, "=")) {
                $sql .= ", ";
            }
            $sql .= "author = \"$author\"";
        }
    } else {
        $Alert->Warning("Selezionare un autore");
    }
    //controllo stato
    if ($status != $fetch['status']) {
        $do_query = true;
        if (str_contains($sql, "=")) {
            $sql .= ", ";
        }
        $sql .= "status = \"$status\"";
    }
    //contorllo immagine
    if (!empty($_FILES['cover']['name'])) {
        $file_extension = pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION);
        $allowed_image_extension = array("png", "jpg", "jpeg", "svg", "icon");
        if (in_array($file_extension, $allowed_image_extension)) {
            $path = $_FILES['cover']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $image_name = "cover" . milliseconds() . "." . $ext;
            $destination = $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/posts/" . $id . "/" . $image_name;
            $result = move_uploaded_file($_FILES['cover']['tmp_name'], $destination);
            if ($result) {
                $do_query = true;
                if (str_contains($sql, "=")) {
                    $sql .= ", ";
                }
                $sql .= "cover = \"$image_name\"";
            } else {
                $Alert->Error("Errore nel caricamento dell'immagine");
            }
        } else {
            $Alert->Warning("Estenzione dell'immagine non supportata");
        }
    }
    //controllo se bisogna apportare modifiche
    if ($do_query) {
        $image_name_old = "";
        if ($image_name != "") {
            $sql_old_image = "SELECT * FROM posts WHERE id =" . "\"$id\"";
            $result = mysqli_query($conn, $sql_old_image);
            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    $result = mysqli_fetch_array($result);
                    $image_name_old = $result['cover'];
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
            $sql = "SELECT * FROM posts WHERE id =" . "\"$id\"";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $fetch = mysqli_fetch_assoc($result);
                if ($image_name != "") {
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/posts/" . $id . "/" . $image_name_old);
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
//aggiunta di un posts
if (isset($_GET['add'])) {
    //presa dei dati
    $title = trim($_POST['title']);
    $content = trim($_POST['content_data']);
    $category = $_POST['category'];
    $author = $_POST['author'];
    $status = (isset($_POST['status']) ? 1 : 0);
    $image_name = "";
    //controllo input testo
    if (empty($title)) {
        $Alert->Warning("Il titolo non può essere vuoto");
    }
    if (empty($content)) {
        $Alert->Warning("Il contenuto non può essere vuoto");
    }
    //controllo autore
    $check_author = 'SELECT * FROM users WHERE id = ' . $author;
    $result = mysqli_query($conn, $check_author);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    if (mysqli_num_rows($result) != 1) {
        $Alert->Error("Errore con il server");
    }
    //controllo categoria
    $check_category = 'SELECT * FROM category WHERE id = ' . $category;
    $result = mysqli_query($conn, $check_category);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    if (mysqli_num_rows($result) != 1) {
        $Alert->Error("Errore con il server");
    }
    //controllo immagine
    if (!empty($_FILES['cover']['name'])) {
        $file_extension = pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION);
        $allowed_image_extension = array("png", "jpg", "jpeg", "svg", "icon");
        if (in_array($file_extension, $allowed_image_extension)) {
            $path = $_FILES['cover']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $image_name = "cover" . milliseconds() . "." . $ext;
        } else {
            $Alert->Error("Estenzione immagine non supportata");
        }
    } else {
        $image_name = "cover.png";
    }
    //controllo contenuto
    $content = str_replace('"', '\"', str_replace("'", "\'", $content));
    //esecuzione query
    $sql = "INSERT INTO posts(author, category, title, content, cover, status) VALUES (" . "\"$author\"" . ", " . "\"$category\"" . ", " . "\"$title\"" . ", " . "\"$content\"" . " , " . "\"$image_name\"" . " , " . "\"$status\"" . ")";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $id = mysqli_insert_id($conn);
        $result = mkdir($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/posts/" . $id);
        if ($result) {
            if (empty($_FILES['cover']['name'])) {
                $result = copy($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/posts/cover.png", $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/posts/" . $id . "/cover.png");
                if ($result) {
                    $Alert->Success("Articolo aggiunto con successo");
                } else {
                    $sql = "DELETE FROM posts WHERE id=" . "\"$id\"";
                    if ($result) {
                        $Alert->Error("Errore nel caricamento della cover");
                    } else {
                        $Alert->Error("Errore con il server");
                    }
                }
            } else {
                $destination = $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/posts/" . $id . "/" . $image_name;
                $result = move_uploaded_file($_FILES['cover']['tmp_name'], $destination);
                if ($result) {
                    $Alert->Success("Articolo aggiunto con successo");
                } else {
                    $sql = "DELETE FROM posts WHERE id=" . "\"$id\"";
                    if ($result) {
                        $Alert->Error("Errore nel caricamento della cover");
                    } else {
                        $Alert->Error("Errore con il server");
                    }
                }
            }
        } else {
            $sql = "DELETE FROM posts WHERE id=" . "\"$id\"";
            if ($result) {
                $Alert->Error("Errore nel caricamento della cover");
            } else {
                $Alert->Error("Errore con il server");
            }
        }
    } else {
        $Alert->Error("Errore con il server");
    }
}
//display della lista di posts
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
    //esecuzione della query
    $query = "SELECT e.*, m.username AS author_username, c.name AS category_name, s.status AS category_status, u.status AS author_status, u.type AS author_type FROM posts e LEFT JOIN users m ON e.author = m.id LEFT JOIN category c ON e.category = c.id LEFT JOIN category s ON e.category = s.id LEFT JOIN users u ON e.author = u.id ";
    if ($_POST['query'] != '') {
        $query .= 'WHERE ' . $_POST['column'] . ' LIKE "%' . str_replace(' ', '%', $_POST['query']) . '%"';
        if (!empty($_POST['only'])) {
            $query .= ' AND ' . $_POST['only'];
        }
    } else {
        if (!empty($_POST['only'])) {
            $query .= ' WHERE ' . $_POST['only'];
        }
    }
    $query .= ' ORDER BY ' . $_POST['column'] . ' ' . $_POST['order'] . ' ';
    $filter_query = $query . 'LIMIT ' . $start . ', ' . $limit . '';
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
    if (!($result || $statement)) {
        $output = '
            <div class="alert alert-danger p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Errore nella ricerca
            </div>
        ';
        $Alert->Custom($output);
    }
    //controllo dei dati
    if ($total_data > 0) {
        $num_card = 0;
        while ($row = mysqli_fetch_array($result)) {
            $num_card++;
            $status = '';
            if ($row['status'] == 0) {
                $status = ' Non pubblicato ';
            }
            if ($row['status'] == 1) {
                $status = ' Pubblicato ';
            }
            $category_status = '';
            if ($row['category_status']) {
                $category_status = '<input onclick="return false;" class="form-check-input bg-success" type="radio">';
            } else {
                $category_status = '<input onclick="return false;" class="form-check-input bg-danger" type="radio">';
            }
            $color_type = "bg-white";
            $author_status = '';
            if ($row['author_username'] == '') {
                $author_status = 'Non presente <input onclick="return false;" class="form-check-input bg-danger" type="radio">';
                $color_type = "bg-dark text-white";
            } else {
                if ($row['author_status'] == 1) {
                    $author_status = '<input onclick="return false;" class="form-check-input bg-success" type="radio">';
                } else if ($row['author_status'] == 2) {
                    $author_status = '<input onclick="return false;" class="form-check-input bg-warning" type="radio">';
                } else if ($row['author_status'] == 0) {
                    $author_status = '<input onclick="return false;" class="form-check-input bg-warning" type="radio">';
                }
                if ($row['author_type'] == 1) {
                    $color_type = "bg-dark text-white";
                }
            }
            $output .= '
                <div class="d-flex ' . $color_type . ' p-3 shadow mb-2" style="border-radius:15px;">
                    <div class="col-auto me-2">
                        <img src="' . InternetFIle('public/assets/posts/' . $row['id'] . '/' . $row['cover'], true) . '" alt="' . $row['cover'] . '" width="65" height="65" class="rounded-circle" style="object-fit: cover;" />
                    </div>
                    <div class="col">
                        <h4 class="mb-0">' . $row['title'] . '</h4>
                        <p class="mb-0">' . $row['category_name'] . ' ' . $category_status . '</p>
                        <p class="mb-1">' . $row['author_username'] . ' ' . $author_status . '</p>
                        <div>
                            <i class="bi bi-caret-left cursor-pointer" onclick="arrow(\'left\', \'status\', \'' . $row['id'] . '\')"></i>
                            <span onclick="arrow(\'right\', \'status\', \'' . $row['id'] . '\')" id="post_status_' . $row['id'] . '">' . $status . '</span>
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
                                <h5 class="modal-title" id="modal-delete-' . $row['id'] . '">Eliminare il post?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                L\'azione è irreversibile, sei sicuro di voler eliminare il post ' . $row['title'] . '?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <button type="button" onclick="delete_posts(' .  $row['id'] . ')" data-bs-dismiss="modal" class="btn btn-danger">Elimina</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
        $output .= ($num_card == 1) ? ('</div id="one-card"></div>') : ('');
        $output .= '<small class="p-0">La query ha prodotto ' . $total_data . ' risultati</small>';
        //paginazione
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
            <div class="alert alert-warning p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Nessun post trovato
            </div>
        ';
        $Alert->Custom($output);
    }
}
//modifica dello stato di un posts
if (isset($_GET['direction']) && isset($_GET['option']) && isset($_GET['id'])) {
    $direction = $_GET['direction'];
    $option = $_GET['option'];
    $id = $_GET['id'];
    $output = "";
    $sql = "SELECT * FROM posts WHERE id = \"$id\"";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $fetch = mysqli_fetch_array($result);
            if ($option == 'status') {
                $status = $fetch['status'];
                if ($direction == 'left') {
                    if (($fetch['status'] - 1) < 0) {
                        $status = 1;
                    } else {
                        $status--;
                    }
                } else if ($direction == 'right') {
                    if (($fetch['status'] + 1) > 1) {
                        $status = 0;
                    } else {
                        $status++;
                    }
                }
                $sql = "UPDATE posts SET status = " . $status . " WHERE id = \"$id\"";
                if ($status == 0) {
                    $output = ' Non pubblicato ';
                }
                if ($status == 1) {
                    $output = ' Pubblicato ';
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
//eliminazione di un post
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM posts WHERE id =" . "\"$id\"";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        deleteAll($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . "/public/assets/posts/" . $id);
        $sql = "DELETE FROM stats WHERE note = " . $id . " AND type = 'post'";
        $result = mysqli_query($conn, $sql);
        $sql = 'SELECT * FROM users WHERE favorites in ("' . $id . '")';
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $string_f = $row['favorites'];
                    $new = str_replace($id.";", "", $string_f);
                    $sql = "UPDATE users SET favorites = '".$new."' WHERE id = " . $row['id'];
                    mysqli_query($conn, $sql);
                }
            }
        }
        $Alert->Success("Account eliminato con successo");
    } else {
        $Alert->Error("Errore con il server");
    }
}
//get dei dati di un posts
if (isset($_GET['get'])) {
    $id = $_GET['get'];
    $sql = "SELECT * FROM posts WHERE id = " . "\"$id\"";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);
    echo json_encode($data);
}

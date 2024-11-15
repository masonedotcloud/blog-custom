<?php
/*
    category.php
    Gestione delle operazioni lato server per la categorie a livello autore / admin
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Author();
//display della lista
if (isset($_GET['search'])) {
    //caratteristiche
    $limit = '12';
    $page = 1;
    //se è impostata la pagina si cambia
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
    //query di base
    $query = "
        SELECT
            e.*,
            m.name AS parent_name,
            COUNT(p.id) AS count_post
        FROM
            category e
        LEFT JOIN category m ON
            e.parent = m.id
        LEFT JOIN posts p ON
            e.id = p.category
    ";
    //se è impostata un parametro di ricerca
    if ($_POST['query'] != '') {
        if ($_POST['column'] == 'parent') {
            $query .= 'WHERE m.name LIKE "%' . str_replace(' ', '%', $_POST['query']) . '%" OR  e.name LIKE "%' . str_replace(' ', '%', $_POST['query']) . '%"';
        } else {
            $query .= 'WHERE e.' . $_POST['column'] . ' LIKE "%' . str_replace(' ', '%', $_POST['query']) . '%" ';
        }
        if (!empty($_POST['only'])) {
            $query .= ' AND ' . $_POST['only'];
        }
    } else {
        if (!empty($_POST['only'])) {
            $query .= ' WHERE ' . $_POST['only'];
        }
    }
    //ordinamento
    $query .= 'GROUP BY p.category, e.id ORDER BY name ' . $_POST['order'] . ' ';
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
    //contorllo se ci sono dati
    if ($total_data > 0) {
        $output = '';
        $num_card = 0;
        while ($row = mysqli_fetch_array($result)) {
            $num_card++;
            $status = ($row['status']) ? ('btn btn-primary') : ('btn btn-outline-primary');
            $parent = ($row['parent_name']) ? ('<span class="badge bg-info text-dark mt-1">Padre ' . $row['parent_name'] . '</span>') : ('');;
            $output .= '
                <div class="alert alert-secondary p-2 d-flex justify-content-between align-items-center mb-2" role="alert">
                    <div class="d-flex flex-column">
                        <h6 class="m-0">' . $row['name'] . '</h6>
                        <span class="badge bg-secondary mt-1">Numero post ' . $row['count_post'] . '</span>
                        ' . $parent . '
                    </div>
                    <div>
                        <button class="' . $status . '" onclick="status_category(' . $row['id'] . ')" id="status-category-' . $row['id'] . '">
                            <i class="bi bi-lightbulb" style="font-size: 1.2rem;"></i>
                        </button>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit" onclick="modal_edit(' . $row['id'] . ')">
                            <i class="bi bi-pencil-square" style="font-size: 1.2rem;"></i>
                        </button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-' . $row['id'] . '">
                            <i class="bi bi-trash" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="modal-delete-' . $row['id'] . '" tabindex="-1" aria-labelledby="modal-delete-' . $row['id'] . '" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-delete-' . $row['id'] . '">Eliminare la categoria?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                L\'azione è irreversibile, sei sicuro di voler eliminare la categoria ' . $row['name'] . '?<br>Così facendo eliminerai anche tutte le sottocategorie
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <button type="button" onclick="delete_category(' .  $row['id'] . ')" data-bs-dismiss="modal" class="btn btn-danger">Elimina</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
        $output .= ($num_card == 1) ? ('</div id="one-card"></div>') : ('');
        //display della paginazione
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
                            <a class="page-link" href="javascript:void(0)" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '
                            </a>
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
                Nessuna categoria trovata
            </div>
        ';
        $Alert->Custom($output);
    }
}
//modifica dello stato di una categoria
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM category WHERE id = $id";
    $status = 0;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch = mysqli_fetch_array($result);
        $sql = '';
        if ($fetch['status']) {
            $status = 0;
            $sql = "UPDATE category SET status = " . $status . " WHERE id = \"$id\"";
        } else {
            $status = 1;
            $sql = "UPDATE category SET status = " . $status . " WHERE id = \"$id\"";
        }
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if ($status != 1) {
                //disattivazione anche delle cagtegorie figlio
                $sql = "UPDATE category SET status = " . $status . " WHERE parent = \"$id\"";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $sql = "SELECT * FROM category WHERE parent = " . "\"$id\"";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            $data = array();
                            while ($row = mysqli_fetch_array($result)) {
                                $data[] = array($row['id'], $row['status']);
                            }
                            $Alert->Custom(json_encode($data));
                        } else {
                            $Alert->Custom('null');
                        }
                    } else {
                        $Alert->Error("Errore con il server");
                    }
                } else {
                    $Alert->Error("Errore con il server");
                }
            } else {
                $Alert->Custom('null');
            }
        } else {
            $Alert->Error("Errore con il server");
        }
    } else {
        $Alert->Error("Errore con il server");
    }
}
//eliminazione della categoria
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($id == 1) {
        $Alert->Error("La categoria non può essere eliminagta");
    }
    $sql = 'UPDATE posts SET category = "1" WHERE category = ' . $id;
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $Alert->Error("Errore con il server");
    }
    $sql = "DELETE FROM category WHERE id = " . "\"$id\"";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql = "DELETE FROM stats WHERE note = " . $id . " AND type = 'category'";
        $result = mysqli_query($conn, $sql);
        //eliminazione delle categorie figlio
        $sql = "SELECT * FROM category WHERE parent = " . "\"$id\"";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = MySQLi_fetch_array($result)) {
                $temp_id = $row['id'];
                $sql = 'UPDATE posts SET category = "1" WHERE category = ' . $temp_id;
                mysqli_query($conn, $sql);
                $sql = "DELETE FROM stats WHERE note = " . $row['id'] . " AND type = 'category'";
                mysqli_query($conn, $sql);
            }
        }
        $sql = "DELETE FROM category WHERE parent = " . "\"$id\"";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $Alert->Success("Categoria eliminata con successo");
        } else {
            $Alert->Error("Errore durante l'eliminazione");
        }
    } else {
        $Alert->Error("Errore durante l'eliminazione");
    }
}
//ritorno dei dati di una categoria
if (isset($_GET['get'])) {
    $id = $_GET['get'];
    $sql = "SELECT * FROM category WHERE id = " . "\"$id\"";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);
    echo json_encode($data);
}
//ritorno delle categorie genitori
if (isset($_GET['option_category'])) {
    $sql = '
        SELECT
            e.*,
            COUNT(p.id) AS count_son
        FROM
            category e
        LEFT JOIN category p ON
            e.id = p.parent
        WHERE
            e.parent = "-1"
        GROUP BY
            p.parent,
            e.id
        ORDER BY e.id DESC
    ';
    //esecuzione della query
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $output = '
            <div class="alert alert-danger p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Errore nella ricerca
            </div>
        ';
        $Alert->Custom($output);
    }
    $total_data = mysqli_num_rows($result);
    $output = '<option value="-1">Nessuna</option>';
    if ($total_data > 0) {
        while ($row = MySQLi_fetch_array($result)) {
            $output .= '<option value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['count_son'] . ')</option>';
        }
    }
    echo $output;
}
//modifica di una categroia 
if (isset($_GET['edit'])) {
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $parent = trim($_POST['parent-category']);
    $status = trim($_POST['status-category']);
    $description = trim($_POST['description']);
    if (!empty($name)) {
        $sql = "SELECT * FROM category WHERE name = " . "\"$name\" AND id <> \"$id\"";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            $sql = "UPDATE category SET name = " . "\"$name\"" . ", parent = " . "\"$parent\"" . ", status = " . "\"$status\"" . ", description = " . "\"$description\"" . " WHERE id = " . "\"$id\"";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $Alert->Success("Modifica avvenuta con successo");
            } else {
                $Alert->Error("Errore con il server");
            }
        } else {
            $Alert->Warning("Categoria già presente");
        }
    } else {
        $Alert->Warning("Il nome non può essere vuoto");
    }
}
//aggiunta di una categoria
if (isset($_GET['add'])) {
    $name = trim($_POST['name']);
    $parent = trim($_POST['parent-category']);
    $status = trim($_POST['status-category']);
    $description = trim($_POST['description']);
    if (!empty($name)) {
        $sql = "SELECT * FROM category WHERE name = " . "\"$name\"";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            $sql = "INSERT INTO category (name, parent, status, description) VALUES (" . "\"$name\"" . ", " . "\"$parent\"" . ", " . "\"$status\"" . ", " . "\"$description\"" . ")";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $Alert->Success("Categoria creata con successo");
            } else {
                $Alert->Error("Errore con il server");
            }
        } else {
            $Alert->Warning("Categoria già presente");
        }
    } else {
        $Alert->Warning("Il nome non può essere vuoto");
    }
}

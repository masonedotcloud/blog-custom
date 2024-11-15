<?php
/*
    newsletter.php
    Gestione delle azioni per l'eiminazione dalla newseltter e l'invio di uhn email a tutti
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Admin();
//display della lista
if (isset($_GET['search'])) {
    //caratteristiche
    $limit = '20';
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
            *,
            LOWER(SUBSTRING_INDEX(email, '@', -1)) AS SERVER,
            LOWER(SUBSTRING_INDEX(email, '.', -1)) AS domain
        FROM
            newsletter
    ";
    //se è impostata un parametro di ricerca
    if ($_POST['query'] != '') {
        if ($_POST['column'] == 'username') {
            $query .= 'WHERE email LIKE "%' . str_replace(' ', '%', $_POST['query']) . '%"';
        }
        if ($_POST['column'] == 'server') {
            $query .= 'WHERE LOWER(SUBSTRING_INDEX(email, "@", -1)) LIKE "%' . str_replace(' ', '%', $_POST['query']) . '%"';
        }
        if ($_POST['column'] == 'domain') {
            $query .= 'WHERE LOWER(SUBSTRING_INDEX(email, ".", -1)) LIKE "%' . str_replace(' ', '%', $_POST['query']) . '%"';
        }
    }
    //ordinamento
    if ($_POST['column'] == 'username') {
        $query .= ' ORDER BY email ' . $_POST['order'];
    }
    if ($_POST['column'] == 'server') {

        $query .= ' order by server ' . $_POST['order'];
    }
    if ($_POST['column'] == 'domain') {
        $query .= ' order by domain ' . $_POST['order'];
    }
    $filter_query = $query . ' LIMIT ' . $start . ', ' . $limit . '';
    //eseguzioni delle query
    $statement = mysqli_query($conn, $query);
    $result = mysqli_query($conn, $filter_query);
    $total_data = mysqli_num_rows($statement);
    $total_filter_data = mysqli_num_rows($statement);
    //display dei risultati o stato
    $output = '';
    if (!($result || $statement)) {
        $output = '
            <div class="alert alert-danger p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Errore nella ricerca
            </div>
        ';
        $Alert->Custom($output);
    }
    //display della lista
    if ($total_data > 0) {
        $num_card = 0;
        while ($row = mysqli_fetch_array($result)) {
            $num_card++;
            $output .= '
                <div class="alert alert-secondary p-2 d-flex justify-content-between align-items-center mb-2" role="alert">
                    <div class="d-flex flex-column">
                        <h6 class="m-0">' . $row['email'] . '</h6>
                        <span class="badge bg-secondary mt-1">' . $row['uni_code'] . '</span>
                    </div>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-' . $row['id'] . '">
                        <i class="bi bi-trash" style="font-size: 1.2rem;"></i>
                    </button>
                </div>
                <div class="modal fade" id="modal-delete-' . $row['id'] . '" tabindex="-1" aria-labelledby="modal-delete-' . $row['id'] . '" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-delete-' . $row['id'] . '">Eliminare l\'iscrizione?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="info-modal-delete-' . $row['id'] . '" class="position-relative d-flex justify-content-end flex-column"></div>
                                L\'azione è irreversibile, sei sicuro di voler eliminare ' . $row['email'] . '?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <button type="submit" onclick="delete_newsletter(' .  $row['id'] . ')" data-bs-dismiss="modal" class="btn btn-danger">Elimina</button>
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
                            <a class="page-link" href="javascript: void(0)"><span aria-hidden="true">&raquo;</span></a>
                        </li>
                    ';
                } else {
                    $next_link = '
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-page_number="' . $next_id . '">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>';
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
                Nessuna newsletter trovata
            </div>
        ';
        $Alert->Custom($output);
    }
}
//invio di un email
if (isset($_GET['send'])) {
    $oggetto = $_POST['oggetto'];
    $content = $_POST['content'];
    if (!empty($oggetto)) {
    } else {
        $Alert->Warning("Oggetto mancante");
    }
    if (!empty($content)) {
    } else {
        $Alert->Warning("Contenuto mancante");
    }
    $result = Send_Custom_Email($content);
    if ($result) {
        $Alert->Success("Email inviata con successo");
    } else {
        $Alert->Error("Errore nell'invio");
    }
}
//eliminazione di un utente alla newsletter
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM newsletter WHERE id = " . "\"$id\"";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $Alert->Success("Account eliminato con successo");
    } else {
        $Alert->Error("Errore durante l'eliminazione");
    }
}

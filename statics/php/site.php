<?php
/*
    site.php
    chiamate generali per il sito e gestione della index
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');

//logo del sito
if (isset($_GET['logo'])) {
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch = mysqli_fetch_array($result);
        $logo = InternetFIle("public/assets/site/" . $fetch['image'], true);
        $Alert->Custom($logo);
    } else {
        $logo = 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Image_created_with_a_mobile_phone.png/1200px-Image_created_with_a_mobile_phone.png';
        $Alert->Custom($logo);
    }
}
//frase
if (isset($_GET['phrases'])) {
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch = mysqli_fetch_array($result);
        $Alert->Custom($fetch['phrase']);
    } else {
        $Alert->Custom('');
    }
}
//nome dell'utente
if (isset($_GET['name'])) {
    if (isset($_SESSION['id'])) {
        $Alert->Custom($_SESSION['name']);
    } else {
        $Alert->Custom("null");
    }
}
//l'avatar dell'utente
if (isset($_GET['avatar'])) {
    if (isset($_SESSION['id'])) {
        $Alert->Custom(InternetFIle("public/assets/users/" . $_SESSION['id'] . "/" . $_SESSION['avatar'], true));
    } else {
        $Alert->Custom("null");
    }
}
//popup del login/sessioni disabilitate
if (isset($_GET['popup'])) {
    if (!LoginStatusSite(1)) {
        $Alert->Info("Il <strong>Login</strong> è al momento disattivato<br>tutte le sessioni presenti<br>sono state disconnesse");
    } else {
        $Alert->Custom("null");
    }
}
//popup delle registrazioni disattivate
if (isset($_GET['popup2'])) {
    $sql = "SELECT * FROM site WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $fetch_login = mysqli_fetch_array($result);
        if ($fetch_login['register'] != 1) {
            $Alert->Info("Le <strong>registrazioni</strong> sul sito<br>sono momentaneamente disabilitate");
        } else {
            $Alert->Custom("null");
        }
    } else {
        $Alert->Custom("null");
    }
}
//pagina delle categorie
if (isset($_GET['search']) && isset($_POST['category']) && $_POST['category'] == 'view_category_list') {
    if (!PoststatusSite()) {
        $output = '
            <div class="alert alert-info p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Visualizzazione dei post e delle categorie disabilitata
            </div>
        ';
        $Alert->Custom($output);
    }
    $limit = '20';
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
    //query delle categorie
    $query = '
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
        WHERE
            e.status = 1
    ';
    //se è presente un argomento di ricerca
    if ($_POST['query'] != '') {
        $query .= ' AND ' . 'e.name' . ' LIKE "%' . str_replace(' ', '%', str_replace('"', '\"', $_POST['query'])) . '%"';
    }
    $query .= '
        GROUP BY
            p.category,
            e.id
        HAVING
            count_post > 0
        ORDER BY
            COUNT(p.id)
        DESC
    ';
    $filter_query = $query . 'LIMIT ' . $start . ', ' . $limit . '';
    //controllo delle query
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
    //controllo dei risultati
    if ($total_data > 0) {
        $output = '<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5"  id="grid">';
        while ($row = mysqli_fetch_array($result)) {
            // (Condition)?(thing's to do if condition true):(thing's to do if condition false);
            $padre = ($row['parent_name']) ? ('Padre: ' . $row['parent_name']) : ('');
            $output .= '
                <div class="col mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['name'] . '</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><span class="badge rounded-pill bg-primary">' . $row['count_post'] . ' articoli</span></h6>
                            <h6 class="card-subtitle mb-2 text-muted">' . $padre . '</h6>
                            <p class="card-text">' . limit_text(Strip_tags($row['description']), 9) . '</p>
                            <a class="card-link" href="javascript:view_category(' . $row['id'] . ');" class="card-link">Visualizza articoli</a>
                        </div>
                    </div>
                </div>
            ';
        }
        $output .= '</div>';
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
            <div class="alert alert-info p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Nessun post trovato
            </div>
        ';
        $Alert->Custom($output);
    }
}
//ricerca dei post
if (isset($_GET['search']) && isset($_POST['category']) && $_POST['category'] != 'view_category_list') {
    if (!PoststatusSite()) {
        $output = '
            <div class="alert alert-info p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Visualizzazione dei post e delle categorie disabilitata
            </div>
        ';
        $Alert->Custom($output);
    }
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
    //query dei post
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
            u.status = 1 AND s.status = 1 AND u.type <> 1
    ';
    //se sono presenti dei termini di paragone
    if ($_POST['category'] != '') {
        $query .= ' AND e.category = ' . $_POST['category'] . ' ';
    }
    if ($_POST['query'] != '') {
        $query .= ' AND ' . '(title' . ' LIKE "%' . str_replace(' ', '%', str_replace('"', '\"', $_POST['query'])) . '%" OR ' . 'content' . ' LIKE "%' . str_replace(' ', '%', str_replace('"', '\"', $_POST['query'])) . '%") ';
    }
    $query .= '
        ORDER BY
            e.date
        DESC
    ';
    $filter_query = $query . 'LIMIT ' . $start . ', ' . $limit . '';
    //esecuzione delle query
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
    //controllo del numero dei dati
    if ($total_data > 0) {
        $output = '<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5" id="grid">';
        while ($row = mysqli_fetch_array($result)) {
            $favorites = '';
            if (isset($_SESSION['id'])) {
                if (str_contains($_SESSION['favorites'], $row['id'] . ';')) {
                    $favorites ='
                        <span class="position-absolute top-0 start-100 translate-middle cursor-pointer" id="favorite-'.$row['id'].'" onclick="delete_favorite('.$row['id'].', \'info\')">
                            <i class="bi bi-star-fill text-warning" style="font-size: 1.5rem;"></i>
                        </span>
                    ';
                }
            }
            $date_post = date('d-m-Y',strtotime($row['date']));
            $output .= '
                <div class="col mb-3">
                    <div class="card">'.
                        $favorites
                        .'<img src="' . InternetFIle('public/assets/posts/' . $row['id'] . '/' . $row['cover'], true) . '" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['title'] . '</h5>
                            <p class="card-text">' . limit_text(Strip_tags($row['content']), 20) . '</p>
                            <div>
                                <i class="bi bi-bookmark me-1"></i>
                                <a class="text-decoration-none" href="index?category='.$row['category_id'].'">'.$row['category_name'].'</a>
                            </div>
                            <div>
                                <i class="bi bi-calendar-week me-1"></i>
                                '.$date_post .'
                            </div>
                            <div>
                                <i class="bi bi-person me-1"></i>
                                '. $row['author_username'] .'
                            </div>
                            <a href="/alessandromasone.altervista.org/post?view='.$row['id'].'" class="btn btn-primary mt-2">Visualizza</a>
                        </div>
                    </div>
                </div>
            ';
        }
        $output .= '</div>';
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
            <div class="alert alert-info p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Nessun post trovato
            </div>
        ';
        $Alert->Custom($output);
    }
}

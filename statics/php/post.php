<?php
/*
    post.php
    controlli e gestione della pagina del post singolo
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
//return di 5 articoli casuali
if (isset($_GET['insert_content_random']) && isset($_GET['number']) && !empty($_GET['number'])) {
    $Account->Open();
    //query per gli articoli casuali
    $number_random_post = $_GET['number'];
    $sql = '
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
            e.status <> "0" AND s.status <> "0" AND u.status <> "2" AND u.status <> "0" AND u.type <> "1"
        ORDER BY
            RAND()
        LIMIT '.$number_random_post;
    //parte superiore con scritto "Altri articoli"
    $output = '
        <ul class="list-group">
            <li class="list-group-item">
                <h4 class="mb-0">Altri articoli</h4>
            </li>
        </ul>
    ';
    //esecuzione della query
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $output .= '
            <div class="alert alert-danger p-3 d-flex justify-content-between align-items-center mb-2" role="alert">
                Errore nella ricerca
            </div>
        ';
        $Alert->Custom($output);
    }
    //display della lista degli articoli
    $total_data = mysqli_num_rows($result);
    if ($total_data > 0) {
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
            $output .= '
                <div class="card mt-2">
                    '.$favorites.'
                    <div class="card-header">
                        <i class="bi bi-bookmark me-1"></i>
                        <a class="text-decoration-none" href="index?category='.$row['category_id'].'">'.$row['category_name'].'</a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $row['title'] . '</h5>
                        <p class="card-text">' . limit_text(Strip_tags($row['content']), 5) . '</p>
                        <a href="post?view='.$row['id'].'" class="btn btn-primary mt-2">Visualizza</a>
                    </div>
                </div>
            ';
        }
        $Alert->Custom($output);
    } else {
        $output .= '
            <div class="alert alert-info p-3 d-flex justify-content-start align-items-center mb-2" role="alert">
                <span>
                    <h4><i class="bi bi-emoji-frown"></i></h4>Nessun post consigliato ci diaspiace
                </span>     
            </div>
        ';
        $Alert->Custom($output);
    }
}

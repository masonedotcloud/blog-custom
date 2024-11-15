<?php
/*
    stats.php
    Gestione delle statistiche del sito
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Admin();
$number_value_access = 30;
$number_value_subscriber = 15;
$number_value_newsletter = 15;
$number_value_category = 5;
//ritorna le visite al sito
if (isset($_GET['access'])) {
    $data = array();
    for ($i = $number_value_access; $i >= 0; $i--) {
        $date = date("Y-m-d", strtotime("-$i days"));
        $sql_ip = "SELECT * FROM stats WHERE date= " . "\"$date\" AND type = 'access'";
        $result_ip = mysqli_query($conn, $sql_ip);
        if ($result_ip) {
            $number_row = mysqli_num_rows($result_ip);

            $date = date('d', strtotime($date));

            $data[] = array($date, $number_row);
        }
    }
    $Alert->Custom(json_encode($data));
}
//registrazioni al sito
if (isset($_GET['subscriber'])) {
    $data = array();
    for ($i = $number_value_subscriber; $i >= 0; $i--) {
        $date = date("Y-m-d", strtotime("-$i days"));
        $sql = "SELECT * FROM stats WHERE date= " . "\"$date\" AND type = 'subscriber'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $number_row = mysqli_num_rows($result);

            $date = date('d', strtotime($date));

            $data[] = array($date, $number_row);
        }
    }
    $Alert->Custom(json_encode($data));
}
//iscrizione alla newsletter
if (isset($_GET['newsletter'])) {
    $data = array();
    for ($i = $number_value_newsletter; $i >= 0; $i--) {
        $date = date("Y-m-d", strtotime("-$i days"));
        $sql = "SELECT * FROM stats WHERE date= " . "\"$date\" AND type = 'newsletter'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $number_row = mysqli_num_rows($result);

            $date = date('d', strtotime($date));

            $data[] = array($date, $number_row);
        }
    }
    $Alert->Custom(json_encode($data));
}
//massimi accessi in un giorno
if (isset($_GET['max_value_access'])) {
    $data = array();
    for ($i = $number_value_access; $i >= 0; $i--) {
        $date = date("Y-m-d", strtotime("-$i days"));
        $sql_ip = "SELECT * FROM stats WHERE date= " . "\"$date\" AND type = 'access'";
        $result_ip = mysqli_query($conn, $sql_ip);
        if ($result_ip) {
            $number_row = mysqli_num_rows($result_ip);
            $data[] = $number_row;
        }
    }
    $Alert->Custom(json_encode(max($data)));
}
//massimi iscritti in un giorno
if (isset($_GET['max_value_subscriber'])) {
    $data = array();
    for ($i = $number_value_subscriber; $i >= 0; $i--) {
        $date = date("Y-m-d", strtotime("-$i days"));
        $sql_ip = "SELECT * FROM stats WHERE date= " . "\"$date\" AND type = 'subscriber'";
        $result_ip = mysqli_query($conn, $sql_ip);
        if ($result_ip) {
            $number_row = mysqli_num_rows($result_ip);
            $data[] = $number_row;
        }
    }
    $Alert->Custom(json_encode(max($data)));
}
//massimi iscritti alla newsletter in un giorno
if (isset($_GET['max_value_newsletter'])) {
    $data = array();
    for ($i = $number_value_newsletter; $i >= 0; $i--) {
        $date = date("Y-m-d", strtotime("-$i days"));
        $sql_ip = "SELECT * FROM stats WHERE date= " . "\"$date\" AND type = 'newsletter'";
        $result_ip = mysqli_query($conn, $sql_ip);
        if ($result_ip) {
            $number_row = mysqli_num_rows($result_ip);
            $data[] = $number_row;
        }
    }
    $Alert->Custom(json_encode(max($data)));
}
//categorie più visitate
if (isset($_GET['category'])) {
    $data = array();
    $date = date("Y-m-d");
    $sql_ip = "
        SELECT
            e.note,
            COUNT(e.id) AS view,
            c.name AS category_name
        FROM
            stats e
        LEFT JOIN category c ON
            e.note = c.id
        WHERE
            e.type = 'category'
        GROUP BY
            e.note LIMIT 5
    ";
    $result_ip = mysqli_query($conn, $sql_ip);
    if ($result_ip) {
        while ($row = MySQLi_fetch_assoc($result_ip)) {
            $data[] = array($row['category_name'], $row['view']);
        }
    }
    $Alert->Custom(json_encode($data));
}
//post più visualizzati
if (isset($_GET['post'])) {
    $data = array();
    $date = date("Y-m-d");
    $sql_ip = "
        SELECT
            e.note,
            COUNT(e.id) AS view,
            c.title AS post_name
        FROM
            stats e
        LEFT JOIN posts c ON
            e.note = c.id
        WHERE
            e.type = 'post'
        GROUP BY
            e.note LIMIT 5
    ";
    $result_ip = mysqli_query($conn, $sql_ip);
    if ($result_ip) {
        while ($row = MySQLi_fetch_assoc($result_ip)) {
            $data[] = array($row['post_name'], $row['view']);
        }
    }
    $Alert->Custom(json_encode($data));
}

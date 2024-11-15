<?php

$src = $_POST["src"];
$to_del = $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' .  parse_url($src, PHP_URL_PATH);
if (file_exists($to_del)) {
    unlink($to_del);
}
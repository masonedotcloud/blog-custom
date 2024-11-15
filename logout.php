<?php
/*
    logout.php
    Uscita dell'account e cancellazione della sessione e dei cookie
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
$redirect = 'index';
session_id("session1");
session_start();
session_destroy();
$Cake->Remove();
header('Location: '. $redirect);
exit(0);

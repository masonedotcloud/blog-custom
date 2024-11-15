<?php
/*
    init.php
    inizializzazione sessione
*/
session_set_cookie_params(time() + (10 * 365 * 24 * 60 * 60));
session_start();

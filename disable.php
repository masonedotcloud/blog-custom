<?php
/*
    disable.php
    Se l'account risulta disattivato l'unica opzione possibile è il logout
*/
$name_page = "Account disattivato";
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Disable();
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/header.php'); ?>

<main>
    <div class="container">
        <div class="alert alert-danger mt-3" role="alert">
            <h4 class="alert-heading">Account disattivato</h4>
            <p>
                Il tuo account è stato disattivato, contatta l'amministratore.
                <br>
                Effettua il <a href="logout" class="alert-link">logout</a> per uscire dal tuo account e visitare il sito come visitatore
            </p>
            <hr>
            <p class="mb-0">Ci dispiace per come siano andate le cose</p>
        </div>
        <div class="text-center">
            <img src="assets/site/Mickey-Mouse.svg" class="rounded" alt="" height="400px" width="auto">
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footbar.php'); ?>

</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footer.php'); ?>
<?php

//restituisce un alert in base ai parametri passati

require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');

if (isset($_GET['type']) && isset($_GET['message'])) {
    $type = $_GET['type'];
    $message = $_GET['message'];
}
?>

<div class="alert alert-<?php echo $type ?> alert-dismissible fade show" role="alert">
    <?php echo $message ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
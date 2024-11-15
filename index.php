<?php
/*
    index.php
    Pagina principale pubblica contenente la visualizzazione dei post o delle categorie
*/
$name_page = "Home";
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Open();
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/header.php'); ?>

<main>
    <div id="info" class="position-absolute d-flex justify-content-end flex-column me-3" style="right: 0; z-index: 1000; margin-top: 75px;"></div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/navbar.php'); ?>
    <div class="container">
        <div class="row mt-2">
            <div class="col-auto">
                <a class="btn btn-primary mb-2" href="index" onclick="view_posts(); return false;"><i class="bi bi-file-post"></i> Clicca qui per i posts</a>
            </div>
            <div class="col-auto">
                <a class="btn btn-warning mb-2" href="index?category=view_category_list" onclick="view_category(); return false;"><i class="bi bi-bookmark-fill"></i> Clicca qui per le categorie</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <input name="search_box" id="search_box" class="form-control mb-3" type="text" placeholder="Ricerca" aria-label="Search">
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="insert-content"></div>
        </div>
    </div>
    <?php $newsletter = true; include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footbar.php'); ?>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/masonry.pkgd.min.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/index.js"></script>
<script type="text/javascript" src="statics/js/newsletter.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footer.php'); ?>
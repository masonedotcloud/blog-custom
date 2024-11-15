<?php
/*
    stats.php
    Statische del sito
*/
$name_page = "Statistiche sito";
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Admin();
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/header.php'); ?>

<main>
    <div id="info" class="position-absolute d-flex justify-content-end flex-column m-3" style="right: 0; z-index: 1000"></div>
    <div class="container-fluid">
        <div class="row">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/navbar.php'); ?>
            <div class="col w-75 min-vh-100 ">
                <h3 class="text-center"><?php echo $name_page ?></h3>
                <div class="row d-flex flex-column">

                    <div class="col mb-3">
                        <div class="d-flex justify-content-center w-100 mt-3" id="loading-div">
                            <div id="loading-access">
                                <div class="clip mb-5">
                                    <img src="<?php echo InternetFIle('assets/site/js_logo.svg', false) ?>">
                                </div>
                            </div>
                        </div>
                        <div id="linechart_access" class="chart m-0 p-0"></div>
                    </div>
                    <div class="col mb-3">
                        <div class="d-flex justify-content-center w-100 mt-3" id="loading-div">
                            <div id="loading-subscriber">
                                <div class="clip mb-5">
                                    <img src="<?php echo InternetFIle('assets/site/js_logo.svg', false) ?>">
                                </div>
                            </div>
                        </div>
                        <div id="linechart_subscriber" class="chart m-0 p-0"></div>
                    </div>
                    <div class="col mb-3">
                        <div class="d-flex justify-content-center w-100 mt-3" id="loading-div">
                            <div id="loading-newsletter">
                                <div class="clip mb-5">
                                    <img src="<?php echo InternetFIle('assets/site/js_logo.svg', false) ?>">
                                </div>
                            </div>
                        </div>
                        <div id="linechart_newsletter" class="chart m-0 p-0"></div>
                    </div>
                    <div class="col mb-3 d-flex flex-column flex-lg-row">
                    <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-center w-100 mt-3" id="loading-div">
                                <div id="loading-category">
                                    <div class="clip mb-5">
                                        <img src="<?php echo InternetFIle('assets/site/js_logo.svg', false) ?>">
                                    </div>
                                </div>
                            </div>
                            <div id="barchart_category" class="chart m-0 p-0"></div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-center w-100 mt-3" id="loading-div">
                                <div id="loading-post">
                                    <div class="clip mb-5">
                                        <img src="<?php echo InternetFIle('assets/site/js_logo.svg', false) ?>">
                                    </div>
                                </div>
                            </div>
                            <div id="barchart_post" class="chart m-0 p-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/charts.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/stats.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/footer.php'); ?>
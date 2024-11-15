<?php
/*
    index.php
    Pagina principale Admin / autore
*/
$name_page = "Dashboard";
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/statics/php/options.php');
$Account->Author();
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/header.php'); ?>

<main>
    <div class="container">
        <div class="row mt-1 mb-4">
            <?php foreach ($options as $option) { ?>
                <?php if ($option['status'] && $option['index']) { ?>
                    <?php if ($_SESSION['type'] == 0) { ?>
                        <div class="col-lg-4 col-md-6 d-flex justify-content-center align-items-center pt-3">
                            <a href="<?php echo $option['link'] ?>" class="d-flex justify-content-center align-items-center btn flex-column white shadow" style="height: 260px; width: 100%; border-radius:25px;" target="<?php echo $option['target'] ?>">
                                <i class="bi bi-<?php echo $option['icon'] ?>" style="font-size: 2.2rem;"></i>
                                <h3><?php echo $option['title'] ?></h3>
                                <?php if (!empty($option['summary'])) { ?>
                                    <span><?php echo $option['summary'] ?></span>
                                <?php } ?>
                            </a>
                        </div>
                    <?php } elseif (!$option['onlyadmin']) { ?>
                        <div class="col-lg-4 col-md-6 d-flex justify-content-center align-items-center pt-3">
                            <a href="<?php echo $option['link'] ?>" class="d-flex justify-content-center align-items-center btn flex-column white shadow" style="height: 260px; width: 100%; border-radius:25px;" target="<?php echo $option['target'] ?>">
                                <i class="bi bi-<?php echo $option['icon'] ?>" style="font-size: 2.5rem;"></i>
                                <h3><?php echo $option['title'] ?></h3>
                                <?php if (!empty($option['summary'])) { ?>
                                    <span><?php echo $option['summary'] ?></span>
                                <?php } ?>
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/index.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/footer.php'); ?>
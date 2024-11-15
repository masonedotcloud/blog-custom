<?php
/*
    posts.php
    Visualizzazione di un singolo post passato per parametro
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Open();
//controllo esistenza articolo
if ((!(isset($_GET['view']) && !empty($_GET['view'])) && get_article($_GET['view']) != false) || !PoststatusSite()) {
    $newURL = '/';
    header('Location: ' . $newURL);
    exit();
}
$article = get_article($_GET['view']);
PostView($article['id']);
CategoryView($article['category']);
$name_page = $article['title'];
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/header.php'); ?>

<main>
    <div id="info" class="position-absolute d-flex justify-content-end flex-column me-3" style="right: 0; z-index: 1000; margin-top: 75px;"></div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/navbar.php'); ?>
    <div class="container">
        <div class="row mt-2">
            <div class="col-auto">
                <a href="index" class="btn btn-primary"><i class="bi bi-house"></i> Vai alla home</a>
            </div>
            <?php if (isset($_SESSION['id'])) { ?>
                <div class="col-auto" id="favorite-<?php echo $article['id'] ?>">
                    <?php if (str_contains($_SESSION['favorites'], $article['id'] . ';')) { ?>
                        <button id="favorite-<?php echo $article['id'] ?>" onclick="delete_favorite('<?php echo $article['id'] ?>', 'info')" type="button" class="btn btn-warning"><i class="bi bi-star-fill"></i> Rimuovi dai preferiti</button>
                    <?php } else { ?>
                        <button id="favorite-<?php echo $article['id'] ?>" onclick="add_favorite('<?php echo $article['id'] ?>', 'info')" type="button" class="btn btn-warning"><i class="bi bi-star-fill"></i> Aggiungi ai preferiti</button>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div class="row content mt-3">
            <div class="col-md-8 col-lg-9 col-xl-9 col-xxl-10 rounded-bottom">
                <div class="content white">
                    <div class="row position-relative">
                        <img class="w-100" src="<?php echo InternetFIle('public/assets/posts/' . $article['id'] . '/' . $article['cover'], true) ?>" alt="" style="opacity: 0.5; height: 150px; object-fit: cover;">
                        <h1 class="mt-5 position-absolute text-center"><?php echo $article['title']; ?></h1>
                    </div>
                    <div class="d-flex justify-content-start align-items-center ps-3 pt-2">
                        <i class="bi bi-bookmark me-1"></i>
                        <a class="text-decoration-none" href="index?category=<?php echo $article['category_id']; ?>"><?php echo $article['category_name']; ?></a>
                        <span class="ms-2 me-2">|</span>
                        <i class="bi bi-calendar-week me-1"></i>
                        <?php echo date('d-m-Y', strtotime($article['date'])); ?>
                        <span class="ms-2 me-2">|</span>
                        <i class="bi bi-person me-1"></i>
                        <?php echo $article['author_username']; ?>
                    </div>
                    <div class="ps-3 pe-3 pb-5">
                        <?php echo $article['content']; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 col-xxl-2" id="insert-content-random"></div>
        </div>
    </div>
    <?php $newsletter = true;
    include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footbar.php'); ?>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/post.js"></script>
<script type="text/javascript" src="statics/js/newsletter.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footer.php'); ?>
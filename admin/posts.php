<?php
/*
    posts.php
    Interfaccia grafica dei posts
*/
$name_page = "Articoli";
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Author();
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/header.php'); ?>

<main>
    <div id="info" class="position-absolute d-flex justify-content-end flex-column m-3" style="right: 0; z-index: 1000"></div>
    <div class="container-fluid">
        <div class="row">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/navbar.php'); ?>
            <div class="col w-75 min-vh-100 ">
                <div class="container mt-2">
                    <h3 class="text-center"><?php echo $name_page ?></h3>
                    <div class="d-flex justify-content-center">
                        <div class="col col-sm-11 col-md-8 col-lg-6 col-xl-5 d-flex justify-content-center flex-column">
                            <div class="row">
                                <div class="input-group p-0">
                                    <input name="search_box" id="search_box" class="form-control" type="text" placeholder="" aria-label="Search">
                                    <div class="dropdown">
                                        <a class="input-group-text dropdown-toggle" href="#" role="button" id="dropdownMenuSearch" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-sliders" style="font-size: 1rem;"></i>
                                        </a>
                                        <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuSearch">
                                            <div class="text">Ordina</div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="order-a-to-z">
                                                <label class="form-check-label" for="order-a-to-z">
                                                    A<i class="bi bi-arrow-right-short"></i>Z
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="order-z-to-a">
                                                <label class="form-check-label" for="order-z-to-a">
                                                    Z<i class="bi bi-arrow-left-short"></i>A
                                                </label>
                                            </div>
                                            <div class="text">Includi</div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-active">
                                                <label class="form-check-label" for="include-active">
                                                    pubblicati
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-disable">
                                                <label class="form-check-label" for="include-disable">
                                                    non pubblicati
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-active-category">
                                                <label class="form-check-label" for="include-active-category">
                                                    categorie<br>attive
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-disable-category">
                                                <label class="form-check-label" for="include-disable-category">
                                                    categorie<br>disattivate
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-active-author">
                                                <label class="form-check-label" for="include-active-author">
                                                    autore<br>attivo
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-disable-author">
                                                <label class="form-check-label" for="include-disable-author">
                                                    autore<br>disattivato
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-not-author">
                                                <label class="form-check-label" for="include-not-author">
                                                    autore<br>non verificato
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-type-author">
                                                <label class="form-check-label" for="include-type-author">
                                                    vecchi<br>autori
                                                </label>
                                            </div>
                                            <label class="form-check-label" for="search-for">
                                                Ricerca per
                                            </label>
                                            <select class="form-select" onchange="search_preference(this.id)" id="search-for">
                                                <option value="title">Titolo</option>
                                                <option value="m.username">Autore</option>
                                                <option value="c.name">Categoria</option>
                                                <option value="content">Contenuto</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2" id="list-posts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <i id="add-button" class="bi bi-plus-square text-dark" style="font-size: 3rem;" data-bs-toggle="modal" data-bs-target="#modal-add"></i>
</main>

<div class="modal fade show" id="modal-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form id="form-add" method="post" class="min-vh-100 d-flex align-items-start flex-column bd-highlight">
                <div class="modal-header mb-auto bd-highlight w-100">
                    <h5 class="modal-title" id="exampleModalLabel">Aggiungi un articolo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bd-highlight w-100">
                    <div id="info-modal-add" class="col"></div>
                    <div class="row">
                        <div class="col-md-9 order-md-1">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="title-add" name="title" value="" placeholder="Titolo">
                            </div>
                            <textarea id="editor-add" name="content_data"></textarea>
                        </div>
                        <div class="col order-md-2">
                            <div class="mb-3">
                                <label class="form-check-label" for="author-add">
                                    Autore
                                </label>
                                <select class="form-select" id="author-add" name="author"></select>
                            </div>
                            <div class="mb-3">
                                <label class="form-check-label" for="category-add">
                                    Categoria
                                </label>
                                <select class="form-select" id="category-add" name="category"></select>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" name="status" type="checkbox" value="" id="status">
                                <label class="form-check-label" for="status-add">
                                    Pubblicato
                                </label>
                            </div>
                            <div class="mb-3">
                                <img id="cover_preview_add" src="<?php echo InternetFIle("public/assets/posts/cover.png", false) ?>" class="w-100 rounded mb-1" alt="..." style="height: 200px; object-fit: cover;">
                                <input type="file" class="form-control" id="cover_add" name="cover">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-auto bd-highlight w-100 d-flex justify-content-between">
                    <div class="">
                        <button type="button" class="btn btn-secondary" id="reset-add-button" onclick="control_two_click()">Reset</button>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Chiudi</button>
                        <button type="submit" id="add-post-button" class="btn btn-primary">Aggiungi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade show" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form id="form-edit" method="post" class="min-vh-100 d-flex align-items-start flex-column bd-highlight">
                <div class="modal-header mb-auto bd-highlight w-100">
                    <h5 class="modal-title" id="name-title-edit">Modifica:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bd-highlight w-100">
                    <div id="info-modal-edit" class="col"></div>
                    <input type="hidden" name="id" id="id-edit" value="">
                    <div class="row">
                        <div class="col-md-9 order-md-1">
                            <div class="mb-3">
                                <label for="title-edit" class="form-label mb-0">Titolo</label>
                                <input type="text" class="form-control" id="title-edit" name="title" value="">
                            </div>
                            <div id="edit-content">
                                <textarea id="editor-edit" name="content_data"></textarea>
                            </div>
                        </div>
                        <div class="col order-md-2">
                            <div class="mb-3">
                                <label class="form-check-label" for="author-edit">
                                    Autore
                                </label>
                                <select class="form-select" id="author-edit" name="author"></select>
                            </div>
                            <div class="mb-3">
                                <label class="form-check-label" for="category-edit">
                                    Categoria
                                </label>
                                <select class="form-select" id="category-edit" name="category"></select>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" name="status" type="checkbox" value="" id="status-edit">
                                <label class="form-check-label" for="status-edit">
                                    Pubblicato
                                </label>
                            </div>
                            <div class="mb-3">
                                <img id="cover_preview_edit" src="<?php echo InternetFIle("public/assets/posts/cover.png", false) ?>" class="w-100 rounded mb-1" alt="..." style="height: 200px; object-fit: cover;">
                                <input type="file" class="form-control" id="cover_edit" name="cover">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-auto bd-highlight w-100">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Chiudi</button>
                    <button type="submit" id="edit-post-button" class="btn btn-primary">Modifica</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/froala_editor.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/align.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/char_counter.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/code_beautifier.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/code_view.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/colors.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/draggable.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/emoticons.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/entities.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/file.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/font_size.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/font_family.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/fullscreen.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/image.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/image_manager.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/line_breaker.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/inline_style.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/link.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/lists.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/paragraph_format.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/paragraph_style.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/quick_insert.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/quote.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/table.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/save.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/url.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/video.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/help.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/print.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/third_party/spell_checker.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/special_characters.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFile('public/statics/froala/js/plugins/word_paste.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/posts.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/footer.php'); ?>
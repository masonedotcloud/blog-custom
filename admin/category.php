<?php
/*
    category.php
    Lista delle categorie e interfacciamento aggiunta / modifica
*/
$name_page = "Categorie";
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
                                                    attive
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-disable">
                                                <label class="form-check-label" for="include-disable">
                                                    disattivate
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-father">
                                                <label class="form-check-label" for="include-father">
                                                    padri
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-son">
                                                <label class="form-check-label" for="include-son">
                                                    figli
                                                </label>
                                            </div>
                                            <label class="form-check-label" for="search-for">
                                                Ricerca per
                                            </label>
                                            <select class="form-select" onchange="search_preference(this.id)" id="search-for">
                                                <option value="name">Nome</option>
                                                <option value="parent">Genitore</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2" id="list-category"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <i id="add-button" class="bi bi-bookmark-plus text-dark" style="font-size: 3rem;" data-bs-toggle="modal" data-bs-target="#modal-add"></i>
</main>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="modal-edit" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="name-title-edit">Modifica:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="info-modal-edit" class="col"></div>
                    <input type="hidden" name="id" id="id-edit" value="">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <div class="input-group flex-nowrap">
                            <input type="name" class="form-control" id="name-edit" name="name" value="">
                            <span onclick="random_username('edit');" class="input-group-text cursor-pointer" id="addon-name-edit"><i class="bi bi-arrow-clockwise"></i></span>
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col me-2">
                            <label for="parent-category-edit" class="form-label">Categoria genitore</label>
                            <select class="form-select" id="parent-category-edit" name="parent-category"></select>
                        </div>
                        <div class="col ms-2">
                            <label for="status-category-edit" class="form-label">Stato</label>
                            <select class="form-select" id="status-category-edit" name="status-category">
                                <option value="1">Attivo</option>
                                <option value="0">Disattivata</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description-edit" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="description-edit" name="description" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-primary">Modifica</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-add" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-add">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aggiungi categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('form-add').reset();"></button>
                </div>
                <div class="modal-body">
                    <div id="info-modal-add" class="col"></div>
                    <input type="hidden" name="id" id="id-add" value="">
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="name" class="form-control" id="name-add" name="name" value="" placeholder="Nome">
                            <span onclick="random_username('name-add', 'info-modal-add');" class="input-group-text cursor-pointer" id="addon-name-add"><i class="bi bi-arrow-clockwise"></i></span>
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col me-2">
                            <label for="parent-category-add" class="form-label mb-0">Categoria genitore</label>
                            <select class="form-select" id="parent-category-add" name="parent-category"></select>
                        </div>
                        <div class="col ms-2">
                            <label for="status-category-add" class="form-label mb-0">Stato</label>
                            <select class="form-select" id="status-category-add" name="status-category">
                                <option value="1">Attivo</option>
                                <option value="0">Disattivata</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="description-add" name="description" rows="10">Descrizione</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="document.getElementById('form-add').reset();">Annulla</button>
                    <button type="submit" class="btn btn-primary">Aggiungi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/zxcvbn.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/category.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/footer.php'); ?>
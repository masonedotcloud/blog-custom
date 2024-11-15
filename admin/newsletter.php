<?php
/*
    newsletter.php
    Pagina di interfacciamneto per la newsletter
*/
$name_page = "Newsletter";
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
                                            <label class="form-check-label" for="search-for">
                                                Ricerca per
                                            </label>
                                            <select class="form-select" onchange="search_preference(this.id)" id="search-for">
                                                <option value="username">Username</option>
                                                <option value="server">Server</option>
                                                <option value="domain">Dominio</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2" id="list-newsletter"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <i id="add-button" class="bi bi-envelope-plus text-dark" style="font-size: 3rem;" data-bs-toggle="modal" data-bs-target="#mail-send"></i>
</main>

<div class="modal fade" id="mail-send" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-send-email" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Scrivi un email a tutti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="oggetto" class="form-label">Oggetto <i class="bi bi-question-circle" data-toggle="tooltip" data-bs-placement="top" title="Inserisci un oggetto che descriva con brevi parole l'email"></i></label>
                        <div class="input-group flex-nowrap">
                            <input onkeypress="return event.charCode != 32" type="text" class="form-control" id="oggetto" name="oggetto" value="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Contenuto email <i class="bi bi-question-circle" data-toggle="tooltip" data-bs-placement="top" title="Inserisci il contenuto della tua email"></i></label>
                        <textarea class="form-control position-relative" id="content" rows="5" name="content"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="control_two_click()" id="send-email-button" class="btn btn-primary">Invia</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/newsletter.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/footer.php'); ?>
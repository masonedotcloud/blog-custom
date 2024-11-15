<?php
/*
    users.php
    Interfacciamento con la gestione degli utente
*/
$name_page = "Utenti";
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
                                            <div class="text">Includi</div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-active">
                                                <label class="form-check-label" for="include-active">
                                                    attivi
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-disable">
                                                <label class="form-check-label" for="include-disable">
                                                    disattivati
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-not-verified">
                                                <label class="form-check-label" for="include-not-verified">
                                                    Non verificati
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-user">
                                                <label class="form-check-label" for="include-user">
                                                    Utenti
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-author">
                                                <label class="form-check-label" for="include-autho">
                                                    Autori
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onchange="search_preference(this.id)" id="include-admin">
                                                <label class="form-check-label" for="include-admin">
                                                    Admin
                                                </label>
                                            </div>

                                            <label class="form-check-label" for="search-for">
                                                Ricerca per
                                            </label>
                                            <select class="form-select" onchange="search_preference(this.id)" id="search-for">
                                                <option value="username">Username</option>
                                                <option value="name">Nome</option>
                                                <option value="surname">Cognome</option>
                                                <option value="email">Email</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2" id="list-users"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <i id="add-button" class="bi bi-person-plus text-dark" style="font-size: 3rem;" data-bs-toggle="modal" data-bs-target="#modal-add"></i>
</main>

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="modal-edit" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-edit" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="username_title-edit">Modifica:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="info-modal-edit" class="col"></div>
                    <input type="hidden" name="id" id="id-edit" value="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group flex-nowrap">
                            <input onkeypress="return event.charCode != 32" type="username" class="form-control" id="username-edit" name="username" value="">
                            <span onclick="random_username('username-edit', 'info-modal-edit');" class="input-group-text cursor-pointer" id="addon-username-edit"><i id="button-eye-username" class="bi bi-arrow-clockwise"></i></span>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="name-edit" class="form-label">Nome</label>
                            <input type="name" class="form-control" id="name-edit" name="name" value="">
                        </div>
                        <div class="col">
                            <label for="surname-edit" class="form-label">Cognome</label>
                            <input type="surname" class="form-control" id="surname-edit" name="surname" value="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email-edit" class="form-label">Email</label>
                        <div class="input-group flex-nowrap">
                            <input onkeypress="return event.charCode != 32" type="email" class="form-control" id="email-edit" name="email" value="">
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col me-2">
                            <label for="type_account-edit" class="form-label">Tipo account</label>
                            <select class="form-select" id="type-account-edit" name="type-account">
                                <option value="0">Admin</option>
                                <option value="1">Utente</option>
                                <option value="2">Autore</option>
                            </select>
                        </div>
                        <div class="col ms-2">
                            <label for="status-account-edit" class="form-label">Stato</label>
                            <select class="form-select" id="status-account-edit" name="status-account">
                                <option value="0">Non verificato</option>
                                <option value="1">Attivo</option>
                                <option value="2">Non attivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="avatar_edit" class="form-label">Avatar profilo</label>
                        <div class="input-group flex-nowrap">
                            <input type="file" class="form-control" id="avatar_edit" name="avatar">
                            <span class="input-group-text" id="addon_avatar_edit"><img class="rounded-circle" id="avatar_preview_edit" src="" alt="" width="20px" height="20px" /></span>
                        </div>
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
        <form id="form-add" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aggiungi utente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('form-add').reset();"></button>
                </div>
                <div class="modal-body">
                    <div id="info-modal-add" class="col"></div>
                    <div class="mb-3">
                        <div class="input-group flex-nowrap">
                            <input onkeypress="return event.charCode != 32" type="username" class="form-control" id="username-add" name="username" value="" placeholder="Username">
                            <span onclick="random_username('username-add', 'info-modal-add');" class="input-group-text cursor-pointer" id="addon-username-add"><i id="button-eye-username" class="bi bi-arrow-clockwise"></i></span>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col">
                            <input type="name" class="form-control" id="name-add" name="name" value="" placeholder="Nome">
                        </div>
                        <div class="col">
                            <input type="surname" class="form-control" id="surname-add" name="surname" value="" placeholder="Cognome">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" id="email-add" name="email" value="" placeholder="Email">
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col me-2">
                            <label for="type_account-add" class="form-label">Tipo account</label>
                            <select class="form-select" id="type-account-add" name="type-account">
                                <option value="0">Admin</option>
                                <option value="1" selected>Utente</option>
                                <option value="2">Autore</option>
                            </select>
                        </div>
                        <div class="col ms-2">
                            <label for="status_account-add" class="form-label">Stato</label>
                            <select class="form-select" id="status-account-add" name="status-account">
                                <option value="0">Non verificato</option>
                                <option value="1">Attivo</option>
                                <option value="2" selected>Non attivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col me-2">
                            <div class="input-group flex-nowrap">
                                <input type="password" class="form-control" id="password" name="password" aria-describedby="addon-password" placeholder="Password">
                                <span onclick="eye_password('password');" class="input-group-text cursor-pointer" id="addon-password"><i id="button-eye-password" class="bi bi-eye-fill"></i></span>
                            </div>
                            <div class="progress password-progress" style="height: 5px;">
                                <div id="password-strength-meter" class="progress-bar" role="progressbar" style="width: 0;"></div>
                            </div>
                        </div>
                        <div class="col ms-2">
                            <div class="input-group flex-nowrap">
                                <input type="password" class="form-control" id="password-check" name="password-check" aria-describedby="addon-password-check" placeholder="Conferma password"/>
                                <span onclick="eye_password('password-check');" class="input-group-text cursor-pointer" id="addon-password-check"><i id="button-eye-password-check" class="bi bi-eye-fill"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="avatar_add" class="form-label mb-0">Avatar profilo</label>
                        <div class="input-group flex-nowrap">
                            <input type="file" class="form-control" id="avatar_add" name="avatar">
                            <span class="input-group-text" id="addon_avatar_add"><img class="rounded-circle" id="avatar_preview_add" src="<?php echo InternetFIle("public/assets/users/avatar.png", false) ?>" alt="" width="20px" height="20px" /></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="document.getElementById('form-add').reset(); $(bar).attr('class', 'progress-bar bg-danger').css('width', '0%');">Annulla</button>
                    <button type="submit" class="btn btn-primary">Aggiungi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/zxcvbn.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/users.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/footer.php'); ?>
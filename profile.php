<?php
/*
    profile.php
    Modifica dei dati dell'account oppure visualizzazione dei preferiti
*/
$name_page = "Dati Account";
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->User();
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/header.php'); ?>

<main>
    <div id="info" class="position-absolute d-flex justify-content-end flex-column me-3" style="right: 0; z-index: 1000; margin-top: 75px;"></div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/navbar.php'); ?>
    <?php if (!isset($_GET['favorites'])) { //pagina normale 
    ?>
        <div class="container d-flex justify-content-center mt-3">
            <div class="bg-white p-3 shadow" style="border-radius:15px;">
                <p class="text-center fs-4"><?php echo $name_page ?></p>
                <form id="form-modifica">
                    <div class="row mb-3">
                        <label for="div-username" class="form-label mb-0">Username</label>
                        <div class="input-group flex-nowrap" id="div-username">
                            <input onkeypress="return event.charCode != 32" type="username" class="form-control" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" placeholder="Username">
                            <span onclick="random_username('username', 'info');" class="input-group-text cursor-pointer" id="addon-username"><i id="button-eye-username" class="bi bi-arrow-clockwise" data-toggle="tooltip" data-bs-placement="top" title="Genera un nome utente casuale"></i></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col pe-1" id="div-name">
                            <label for="name" class="form-label mb-0">Nome</label>
                            <input type="name" class="form-control" id="name" name="name" placeholder="Nome" value="<?php echo $_SESSION['name']; ?>">
                        </div>
                        <div class="col ps-1" id="div-surname">
                            <label for="surname" class="form-label mb-0">Cognome</label>
                            <input type="surname" class="form-control" id="surname" name="surname" placeholder="Cognome" value="<?php echo $_SESSION['surname']; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="div-email" class="form-label mb-0">Email</label>
                        <div class="input-group" id="div-email">
                            <input oninput="check_change_email();" type="text" class="form-control" id="email" name="email" value="<?php echo $_SESSION['email']; ?>">
                            <div id="email-status" data-toggle="tooltip" data-bs-placement="top" title="Email confermata" class="input-group-text">
                                <span class="cursor-pointer"><i class="bi bi-check-lg"></i></span>
                            </div>
                        </div>
                    </div>
                    <label for="div-change-password" class="form-label mb-0">Cambio password</label>
                    <div id="div-change-password" class="border rounded p-2 mb-3">
                        <div class="">
                            <div class="input-group mb-2">
                                <input type="password" class="form-control" id="password-old" name="password-old" placeholder="Vecchia password">
                                <span onclick="eye_password('password-old');" class="input-group-text cursor-pointer" id="addon-password-old"><i id="button-eye-password-old" class="bi bi-eye-fill"></i></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pe-1">
                                <div class="input-group flex-nowrap">
                                    <input type="password" class="form-control" id="password" name="password" aria-describedby="addon-password" placeholder="Password">
                                    <span onclick="eye_password('password');" class="input-group-text cursor-pointer" id="addon-password"><i id="button-eye-password" class="bi bi-eye-fill"></i></span>
                                </div>
                                <div class="progress password-progress" style="height: 5px;">
                                    <div id="password-strength-meter" class="progress-bar" role="progressbar" style="width: 0;"></div>
                                </div>
                            </div>
                            <div class="col ps-1">
                                <div class="input-group flex-nowrap">
                                    <input type="password" class="form-control" id="password-check" name="password-check" aria-describedby="addon-password-check" placeholder="Conferma">
                                    <span onclick="eye_password('password-check');" class="input-group-text cursor-pointer" id="addon-password-check"><i id="button-eye-password-check" class="bi bi-eye-fill"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="div-avatar" class="form-label mb-0">Avatar profilo <i class="bi bi-question-circle" data-toggle="tooltip" data-bs-placement="top" title="I formati consentiti sono (.png, .jpg, .jpeg, .svg, .icon) può essere lasciato vuoto"></i></label>
                        <div class="input-group" id="div-avatar">
                            <input type="file" class="form-control" id="avatar" name="avatar">
                            <span data-toggle="tooltip" data-bs-placement="top" title="Anteprima dell'immagine" class="input-group-text" id="addon-avatar"><img class="rounded-circle" id="avatar_preview" src="<?php echo InternetFIle("public/assets/users/avatar.png", false) ?>" alt="your image" width="20px" height="20px" /></span>
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                        <?php if (isset($_SESSION['reset_password_otp']) && !empty($_SESSION['reset_password_otp'])) { ?>
                            <button type="button" onclick="delete_request_reset_password()" class="btn btn-success bg-green-fb me-1" data-toggle="tooltip" data-bs-placement="top" title="Richiesta di reset password attiva, clicca per eliminarla">
                                <i class="bi bi-key"></i>
                            </button>
                        <?php } ?>
                        <button type="submit" class="btn btn-primary w-100">Applica modifiche</button>
                        <button type="button" class="btn btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#modal-delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="modal-code" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-label">Inserisci il codice di verifica</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="info-modal-email" class="position-relative d-flex justify-content-end flex-column"></div>
                        <input type="hidden" name="modal" value="active">
                        <div class="mb-3">
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" id="code-modal" name="code" placeholder="Codice">
                        </div>
                        <div class="mt-3">
                            <p class="d-flex justify-content-center align-items-center">
                                Codice non arrivato?<span class="link-primary cursor-pointer text-decoration-none" onclick="send_code_change_mail('info-modal-email');">&nbsp;Richiedi nuovamente il codice</span>
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annulla</button>
                        <button type="button" id="confirm-email-modal" onclick="check_code_change_mail();" class="btn btn-primary">Conferma</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="modal-deleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-deleteLabel">Sei sciuto di voler elimintare il tuo account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="info-modal-delete" class="position-relative d-flex justify-content-end flex-column"></div>
                        <label for="delete-confirm" class="form-label">Scrivi "elimina" per confermare l'operazione</label>
                        <input type="text" id="delete-confirm" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('delete-confirm').value = '';" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="delete_account()">Elimina</button>
                    </div>
                </div>
            </div>
        </div>

    <?php } else if (isset($_GET['favorites'])) { //pagina dei preferiti 
    ?>
        <div class="container">
            <a href="index" class="btn btn-primary m-2 ms-0"><i class="bi bi-house"></i> Vai alla home</a>
            <input name="search_box" id="search_box" class="form-control mb-3" type="text" placeholder="Ricerca" aria-label="Search">
            <div class="mt-3" id="personal-favorites-list"></div>
        </div>
    <?php } ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footbar.php'); ?>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/masonry.pkgd.min.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/zxcvbn.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/profile.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footer.php'); ?>
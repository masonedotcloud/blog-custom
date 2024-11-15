<?php
/*
    password.php
    Pagina di richiesta cambio password attraverso l'email con successivo otp all'email (univoco) per il cambio password
*/
$name_page = "Password";
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Guest();
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/header.php'); ?>

<main>
    <div id="info" class="position-absolute d-flex justify-content-end flex-column m-3" style="right: 0; z-index: 1000"></div>
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-center">
                <a href="index" class="p-3">
                    <img src="" alt="logo-site" id="big-logo" width="80" height="80" />
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="bg-white p-3 shadow" style="width: 400px; border-radius:15px;">
                    <p class="text-center fs-4"><?php echo $name_page ?></p>
                    <?php if (isset($_GET['otp']) && opt_password_exists($_GET['otp'])) { //cambio password?>
                        <form id="data-password">
                            <p class="text-center">Inserisci la nuova password per effettuare la modifica</p>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" aria-describedby="addon-password" placeholder="Nuova password">
                                <span onclick="eye_password('password');" class="input-group-text cursor-pointer" id="addon-password"><i id="button-eye-password" class="bi bi-eye-fill"></i></span>
                            </div>
                            <div class="progress password-progress mb-2" style="height: 5px;">
                                <div id="password-strength-meter" class="progress-bar" role="progressbar" style="width: 0;"></div>
                            </div>
                            <div class="input-group flex-nowrap mb-3">
                                <input type="password" class="form-control" id="password-check" name="password-check" aria-describedby="addon-password-check" placeholder="Conferma">
                                <span onclick="eye_password('password-check');" class="input-group-text cursor-pointer" id="addon-password-check"><i id="button-eye-password-check" class="bi bi-eye-fill"></i></span>
                            </div>
                            <button type="submit" type="button" class="btn btn-primary w-100"><strong class="ps-3 pe-3">Modifica</strong></button>
                        </form>
                    <?php } else { //richesta cambio password?>
                        <form id="form-email">
                            <p class="text-center">Inserisci la tua email e riceverai il link per reimpostare la tua password</p>
                            <input type="text" class="form-control mb-3" id="email" name="email" placeholder="Email">
                            <button type="submit" type="button" class="btn btn-primary w-100 mb-3"><strong class="ps-3 pe-3">Richiedi</strong></button>
                        </form>
                        <div class="d-flex flex-column">
                            <span class="text-center ">oppure</span>
                            <span class="text-center">
                                <a href="login" class="link-primary text-decoration-none">effettua il login</a>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footbar.php'); ?>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/zxcvbn.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/password.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footer.php'); ?>
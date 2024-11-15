<?php
/*
    login.php
    Pagina di login all'account con email e password solo per che non ha una sessione
*/
$name_page = "Accedi";
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
                    <form id="form-login">
                        <input type="text" class="form-control mb-3" id="email" name="email" placeholder="Email">
                        <div class="input-group mb-2">
                            <input type="password" class="form-control" id="password" name="password" aria-describedby="addon-password" placeholder="Password">
                            <span onclick="eye_password('password');" class="input-group-text cursor-pointer" id="addon-password"><i id="button-eye-password" class="bi bi-eye-fill"></i></span>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ricordami</label>
                        </div>
                        <button type="submit" type="button" class="btn btn-primary w-100"><strong class="ps-3 pe-3">Accedi</strong></button>
                    </form>
                    <a href="password" class="link-primary d-flex justify-content-center text-decoration-none mt-3">Password dimenticaticata?</a>
                    <div class="d-flex flex-row w-100 align-items-center">
                        <hr class="w-100">
                        <span class="m-2">o</span>
                        <hr class="w-100">
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <a href="register" type="button" class="btn btn-success bg-green-fb"><strong>Crea un nuovo account</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footbar.php'); ?>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/login.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footer.php'); ?>
<?php
/*
    register.php
    Registrazione dell'utente al sito
*/
$name_page = "Crea un nuovo account";
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
                    <form id="form-register">
                        <div class="input-group mb-3">
                            <input onkeypress="return event.charCode != 32" type="username" class="form-control" id="username" name="username" value="" placeholder="Username">
                            <span onclick="random_username('username', 'info');" class="input-group-text cursor-pointer" id="addon-username"><i id="button-eye-username" class="bi bi-arrow-clockwise" data-toggle="tooltip" data-bs-placement="top" title="Genera un nome utente casuale"></i></span>
                        </div>
                        <div class="row mb-3">
                            <div class="col pe-1">
                                <input type="name" class="form-control" id="name" name="name" placeholder="Nome">
                            </div>
                            <div class="col ps-1">
                                <input type="surname" class="form-control" id="surname" name="surname" placeholder="Cognome">
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="row mb-3">
                            <div class="col pe-1">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" aria-describedby="addon-password" placeholder="Password">
                                    <span onclick="eye_password('password');" class="input-group-text cursor-pointer" id="addon-password"><i id="button-eye-password" class="bi bi-eye-fill"></i></span>
                                </div>
                                <div class="progress password-progress" style="height: 5px;">
                                    <div id="password-strength-meter" class="progress-bar" role="progressbar" style="width: 0;"></div>
                                </div>
                            </div>
                            <div class="col ps-1">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password-check" name="password-check" aria-describedby="addon-password-check" placeholder="Conferma">
                                    <span onclick="eye_password('password-check');" class="input-group-text cursor-pointer" id="addon-password-check"><i id="button-eye-password-check" class="bi bi-eye-fill"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <label for="div-avatar" class="form-label mb-1">Avatar profilo <i class="bi bi-question-circle" data-toggle="tooltip" data-bs-placement="top" title="I formati consentiti sono (.png, .jpg, .jpeg, .svg, .icon) può essere lasciato vuoto"></i></label>
                            <div class="input-group flex-nowrap" id="div-avatar">
                                <input type="file" class="form-control" id="avatar" name="avatar">
                                <span data-toggle="tooltip" data-bs-placement="top" title="Anteprima dell'immagine" class="input-group-text" id="addon-avatar"><img class="rounded-circle" id="avatar_preview" src="<?php echo InternetFIle("public/assets/users/avatar.png", false) ?>" alt="your image" width="20px" height="20px" /></span>
                            </div>
                        </div>
                        <button type="submit" type="button" class="btn btn-primary w-100"><strong class="ps-3 pe-3">Registrati</strong></button>
                    </form>
                    <a href="login" class="link-primary d-flex justify-content-center text-decoration-none mt-2">Hai già un account?</a>
                </div>
            </div>
        </div>
    </div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footbar.php'); ?>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/zxcvbn.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/register.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footer.php'); ?>
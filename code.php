<?php
/*
    code.php
    Pagina di inserimento del codice per la verifica dell'account
*/
$name_page = "Verifica account";
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
$Account->Code();
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
                    <form id="code-form">
                        <input type="hidden" name="code-form" value="active">
                        <p class="text-center">
                            Devi effettuare la verifica del tuo account con il codice inviato a <?php echo $_SESSION['email'] ?>,
                            altrimenti puoi effettuare il <a href="logout" class="link-primary cursor-pointer text-decoration-none">logout</a> ed effettuare la verifica un altro giorno
                        </p>
                        <input type="text" class="form-control mb-3" id="code" name="code" placeholder="Codice">
                        <button type="submit" class="btn btn-primary w-100">Verifica</button>
                    </form>
                    <div class="d-flex justify-content-center align-items-center mt-2">
                        <span onclick="send_code('info');" class="link-primary cursor-pointer text-decoration-none">Richiedi nuovamente il codice</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footbar.php'); ?>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/code.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/footer.php'); ?>
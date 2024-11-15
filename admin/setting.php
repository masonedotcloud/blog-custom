<?php
/*
    setting.php
    Visualizzazione e modifica delle impostazioni basi del sito
*/
$name_page = "Impostazioni sito";
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
                            <form id="data" method="post">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome <i class="bi bi-question-circle" data-toggle="tooltip" data-bs-placement="top" title="Inserisci un name che doni al sito!!"></i></label>
                                    <div class="input-group flex-nowrap">
                                        <input onkeypress="return event.charCode != 32" type="name" class="form-control" id="name" name="name" value="">
                                        <span onclick="random_username('name', 'info');" class="input-group-text cursor-pointer" id="addon-name"><i id="button-eye-name" class="bi bi-arrow-clockwise" data-toggle="tooltip" data-bs-placement="top" title="Genera un nome casuale per il sito"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <i class="bi bi-question-circle" data-toggle="tooltip" data-bs-placement="top" title="Inserisci l'email del sito"></i></label>
                                    <input onkeypress="return event.charCode != 32" type="email" class="form-control" id="email" name="email" value="">
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-auto">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="login" onclick="login_switch()">
                                            <label class="form-check-label" for="login" id="login" name="login">Stato login</label>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="register" onclick="register_switch()">
                                            <label class="form-check-label" for="register" id="register" name="register">Stato registrazione</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="posts" onclick="posts_switch()">
                                            <label class="form-check-label" for="posts" id="posts" name="posts">Stato posts</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="debug" onclick="debug_switch()">
                                            <label class="form-check-label" for="debug" id="debug" name="debug">Debug</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phrase" class="form-label">Frase Header <i class="bi bi-question-circle" data-toggle="tooltip" data-bs-placement="top" title="Inserisci la frase dell'header"></i></label>
                                    <input onkeypress="return event.charCode != 32" type="text" class="form-control" id="phrase" name="phrase" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descrizione <i class="bi bi-question-circle" data-toggle="tooltip" data-bs-placement="top" title="Inserisci una desrizione del sito"></i></label>
                                    <textarea class="form-control" id="description" rows="13" name="description"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Icona sito <i class="bi bi-question-circle" data-toggle="tooltip" data-bs-placement="top" title="I formati consentiti sono (.png, .jpg, .jpeg, .svg, .icon)"></i></label>
                                    <div class="input-group flex-nowrap">

                                        <input type="file" class="form-control" id="image" name="image">
                                        <span data-toggle="tooltip" data-bs-placement="top" title="Anteprima dell'immagine" class="input-group-text" id="addon-image"><img class="" id="image_preview" src="" alt="your image" width="20px" height="20px" /></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 w-100">Modifica</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript" src="<?php echo InternetFIle('public/statics/js/function.js', false) ?>"></script>
<script type="text/javascript" src="statics/js/setting.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/includes/footer.php'); ?>
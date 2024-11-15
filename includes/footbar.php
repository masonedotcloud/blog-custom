<div style="height: 120px"></div>

<footer id="footer" class="white text-center text-lg-start w-100">
    <?php
    if (isset($newsletter) && $newsletter == true) {
        include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/includes/newsletter.php');
    }
    ?>
    <div class="white text-center p-3">© 2022 Copyright: <a class="text-decoration-none" href="<?php echo InternetFile('', true) ?>"><?php echo $_SERVER['SERVER_NAME'] ?></a>
    </div>
</footer>
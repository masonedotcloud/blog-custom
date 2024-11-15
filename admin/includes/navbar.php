<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/admin/statics/php/options.php'); ?>

<div class="bg-light sticky-top" id="sidebar">
    <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top">
        <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center justify-content-center w-100 px-3 align-items-center">
            <?php foreach ($options as $option) { ?>
                <?php if ($option['status'] && $option['sidebar']) { ?>
                    <?php if ($_SESSION['type'] == 0) { ?>
                        <li class="nav-item">
                            <a href="<?php echo $option['link'] ?>" class="nav-link px-2 text-dark" target="<?php echo $option['target'] ?>" data-toggle="tooltip" data-bs-placement="bottom" title="<?php echo $option['title'] ?>">
                                <i class="navbar-ico bi bi-<?php echo $option['icon'] ?>"></i> </a>
                        </li>
                    <?php } elseif (!$option['onlyadmin']) { ?>
                        <li class="nav-item">
                            <a href="<?php echo $option['link'] ?>" class="nav-link px-2 text-dark" target="<?php echo $option['target'] ?>">
                                <i class="navbar-ico bi bi-<?php echo $option['icon'] ?>"></i> </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>
<nav id="nav" class="navbar navbar-expand-lg border-bottom white w-100">
    <div class="container-fluid flex-nowrap">
        <ul class="navbar-nav d-flex flex-row me-3">
            <li class="nav-item">
                <a class="navbar-brand" href="index">
                    <img src="" id="setting_site_logo" width="40" height="40" />
                </a>
            </li>
            <li class="nav-item d-flex align-items-center" id="phrases-effect"></li>
        </ul>
        <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item d-flex align-items-center">
                <?php if (isset($_SESSION['id'])) { ?>
                    <span class="me-3 d-none d-sm-block">Benvenuto, <a href="profile" class="link-primary text-decoration-none" id="user_name"></a></span>
                <?php } else { ?>
                    <span class="me-3 d-none d-sm-block">Benvenuto, <a href="login" class="link-primary text-decoration-none">accedi</a></span>
                <?php } ?>
            </li>
            <?php if (isset($_SESSION['id'])) { ?>
                <li class="nav-item me-2">
                    <img src="" width="40" height="40" class="rounded-circle" alt="" data-bs-toggle="dropdown" aria-expanded="false" id="user_avatar">
                    <ul class="m-3 dropdown-menu position-absolute dropdown-menu-end" style="z-index: 1001">
                        <li class="nav-item d-flex justify-content-start">
                            <a class="dropdown-item ps-0 d-flex align-items-center" href="index">
                                <i class="bi bi-house-fill ms-3 me-2" style="font-size: 1.25rem;"></i>
                                Vai al sito
                            </a>
                        </li>
                        <?php if ($_SESSION['type'] != 1) { ?>
                            <li class="nav-item d-flex justify-content-start">
                                <a class="dropdown-item ps-0 d-flex align-items-center" href="admin" target="_blank">
                                    <i class="bi bi-speedometer2 ms-3 me-2" style="font-size: 1.25rem;"></i>
                                    Dashboard
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="nav-item d-flex justify-content-start">
                            <a class="dropdown-item ps-0 d-flex align-items-center" href="profile">
                                <i class="bi bi-person-lines-fill ms-3 me-2" style="font-size: 1.25rem;"></i>
                                Profile
                            </a>
                        </li>
                        <li class="nav-item d-flex justify-content-start">
                            <a class="dropdown-item ps-0 d-flex align-items-center" href="profile?favorites">
                                <i class="bi bi-star-fill ms-3 me-2" style="font-size: 1.25rem;"></i>
                                Preferiti
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="nav-item d-flex justify-content-start">
                            <a class="dropdown-item ps-0 d-flex align-items-center" href="logout">
                                <i class="bi bi-door-open ms-3 me-2" style="font-size: 1.25rem;"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } else { ?>
                <li class="nav-item me-2">
                    <a href="login" class="text-dark">
                        <i class="bi bi-person-circle" style="font-size: 2.5rem;"></i>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>

<script type="text/javascript" src="statics/js/navbar.js"></script>
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="z-index: 999;">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img-1/bg.png" alt="Logo" class=" js-logo__image" width="60px" data-switch="true"></a>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse align-items-center justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 pe-3">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <?php
                if (isset($_SESSION['login_id'])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="logout.php">Logout</a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="signup.php">Signup</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
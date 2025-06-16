<?php
session_start();

if (isset($_SESSION['login_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['redirect'])) {
    $_SESSION['redirect_url'] = $_GET['redirect'];
}
if (isset($_GET['plan'])) {
    $_SESSION['plan'] = $_GET['plan'];
}

function old($key)
{
    return isset($_SESSION['oldData'][$key]) ? $_SESSION['oldData'][$key] : '';
}
include_once 'include/head.php';
?>

<body>
    <?php
    if (isset($_SESSION['status']) == true) {
        echo '
        <script>
    Swal.fire({
        text: "' . $_SESSION['message'] . '",
        icon: "' . $_SESSION['icon'] . '"
      });
      </script>
    ';
        unset($_SESSION['message']);
        unset($_SESSION['icon']);
        unset($_SESSION['status']);
    }
    ?>


    <div class="preloader js-preloader ">
        <span class="preloader__circle preloader__circle--primary"></span>
        <span class="preloader__circle preloader__circle--secondary"></span>
        <span class="preloader__circle preloader__circle--tertiary"></span>
    </div>
    <?php include('include/guest_navbar.php'); ?>
    <div class="form-body without-side">
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="assets/img-1/auth-bg.jpg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Login to account</h3>
                        <p>Welcome back to Tunnel VPN</p>
                        <form method="post" name="myForm" action="backend/auth/user-management.php">
                            <input class="form-control" type="text" name="username" value="<?= old('username') ?>" placeholder="E-mail Address" required>
                            <div class="position-relative show_hide_password">
                                <input class="form-control" type="password" name="password" value="<?= old('password') ?>" placeholder="Password" id="password" required>
                                <a href="javascript:;" class="bg-transparent pass-icon"><i class="fa-solid fa-eye"></i></a>
                            </div>
                            <div class="form-button">
                                <button id="submit" type="submit" name="loginuser" class="ibtn">Login</button>
                                <a href="forget-password.php" class="text-dark">Forget password?</a>
                            </div>
                        </form>

                        <div class="other-links" style="text-decoration: none;">
                            <div class="text">Or login with</div>
                            <?php
                            $clientId = 'com.griddownlllc.tunnel';
                            $redirectUri = urlencode('https://account.tunnelvpn.com/apple_callback.php');
                            $scope = urlencode('name email');
                            $responseMode = 'form_post'; // Required when requesting name or email

                            $authorizationUrl = "https://appleid.apple.com/auth/authorize?" .
                                "client_id=$clientId" .
                                "&redirect_uri=$redirectUri" .
                                "&response_type=code" .
                                "&scope=$scope" .
                                "&response_mode=$responseMode";
                            echo '<a href="' . $authorizationUrl . '" class="text-decoration-none"><i class="fab fa-apple"></i>Apple ID</a>';
                            ?>
                            <!-- <a href="https://appleid.apple.com/auth/authorize?client_id=com.griddownlllc.tunnel&redirect_uri=https://localhost/vsapp/apple_callback.php&response_type=code&scope=name%20email&response_mode=form_post" class="text-decoration-none"><i class="fab fa-apple"></i>Apple ID</a> -->
                            <a href="google_login.php" class="text-decoration-none"><i class="fab fa-google"></i>Google</a>
                        </div>

                        <div class="page-links mt-4">
                            <p> You don't have a account ? <a href="signup.php">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="dist/script.js"></script>

    <script>
        $(document).ready(function() {
            $(".show_hide_password a").on('click', function(event) {
                event.preventDefault();

                // Find the input field within the same parent div
                var $passwordInput = $(this).closest('.show_hide_password').find('input');

                // Toggle password visibility
                if ($passwordInput.attr("type") === "password") {
                    $passwordInput.attr('type', 'text');
                    $(this).find('i').removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    $passwordInput.attr('type', 'password');
                    $(this).find('i').removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });
        });
    </script>
</body>

</html>

<?php
unset($_SESSION['oldData']);
?>
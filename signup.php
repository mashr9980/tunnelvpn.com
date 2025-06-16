<?php
session_start();

if (isset($_SESSION['login_id'])) {
    header("Location: index.php");
    exit();
}

function old($key)
{
    return isset($_SESSION['oldData'][$key]) ? $_SESSION['oldData'][$key] : '';
}
include_once 'include/head.php';
?>
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

<body>
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
                        <h4 style="font-weight: 700 ;">Welcome To TunnelVPN</h4>
                        <p>Register your account</p>
                        <form>
                            <input class="form-control" type="text" name="username" placeholder="Username" value="<?= old('username') ?>" id="username" required>
                            <input class="form-control" type="text" name="email" placeholder="E-mail Address" value="<?= old('email') ?>" id="email" required>

                            <div class="position-relative show_hide_password">
                                <input class="form-control" type="password" name="password" placeholder="Password" id="password" required>
                                <a href="javascript:;" class="bg-transparent pass-icon"><i class="fa-solid fa-eye"></i></a>
                            </div>
                            <div class="position-relative show_hide_password">
                                <input class="form-control" type="password" name="password" placeholder="Confirm Password" id="c_password" required>
                                <a href="javascript:;" class="bg-transparent pass-icon"><i class="fa-solid fa-eye"></i></a>
                            </div>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Register</button>
                            </div>
                        </form>

                        <div class="page-links mt-4">
                            <p> You have a account ? <a href="login.php">Login</a></p>
                        </div>
                        <p class="mt-3 mb-0 pb-0" id="alert_msg"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="dist/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script>
        $(document).ready(function() {
            $("#alert_msg").hide();
            $("#submit").on('click', function(e) {
                e.preventDefault();
                var username = $("#username").val();
                var email = $("#email").val();
                var password = $("#password").val();
                var c_password = $("#c_password").val();

                // emptyfield validation
                if (username == '' || email == '' || password == '' || c_password == '') {
                    $("#alert_msg").show().text("Please fill all the fields");
                    return false;
                }

                if (password != c_password) {
                    $("#alert_msg").show().text('Password and Confirm Password does not match')
                    return false;
                }

                $.ajax({
                    url: 'backend/api/user-auth-api.php?action=register',
                    type: 'POST',
                    data: JSON.stringify({
                        name: username,
                        email: email,
                        password: password
                    }),
                    beforeSend: function() {
                        $("#submit").text('Please wait...');
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == true) {
                            showMsg('success', 'Sign Up Successfully.');
                            setTimeout(function() {
                                window.location.href = 'login.php';
                            }, 2000);
                        } else {
                            $("#alert_msg").show().text(response.message);
                            $("#submit").text('Register');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                })

                function showMsg(type, msg) {
                    Swal.fire({
                        text: msg,
                        icon: type
                    });
                }
            })
        })
    </script>
</body>

</html>

<?php
unset($_SESSION['oldData']);
?>
<?php
session_start();

if (isset($_SESSION['login_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['token'])) {
    header("Location: login.php");
    exit();
}

$token = isset($_GET['token']) ? $_GET['token'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TunnelVPN</title>
    <link rel="stylesheet" href="dist/style.css">
    <link rel="stylesheet" href="dist/iofrm-style.css">
    <link rel="stylesheet" href="dist/iofrm-theme.css">
    <link rel="stylesheet" href="dist/payment.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

</head>

<body>
    <div class="preloader js-preloader ">
        <span class="preloader__circle preloader__circle--primary"></span>
        <span class="preloader__circle preloader__circle--secondary"></span>
        <span class="preloader__circle preloader__circle--tertiary"></span>
    </div>
    <div class="form-body without-side">
        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="logo-size" src="images/logo-light.svg" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Set a New Password </h3>
                        <p>Please Enter Your New Password.</p>
                        <form>
                            <input type="hidden" value="<?php echo $token ?>" name="token" id="token">
                            <div class="position-relative show_hide_password">
                                <input class="form-control" type="password" name="password" placeholder="Password" id="password" required>
                                <a href="javascript:;" class="bg-transparent pass-icon"><i class="fa-solid fa-eye"></i></a>
                            </div>
                            <div class="position-relative show_hide_password">
                                <input class="form-control" type="password" name="password" placeholder="Confirm Password" id="c_password" required>
                                <a href="javascript:;" class="bg-transparent pass-icon"><i class="fa-solid fa-eye"></i></a>
                            </div>
                            <div class="form-button full-width">
                                <button id="submit" name="loginuser" type="submit" class="ibtn btn-forget">Save</button>
                            </div>
                        </form>
                        <p class="mt-3 mb-0 pb-0" id="alert_msg"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="dist/script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                var token = $("#token").val();
                var password = $("#password").val();
                var c_password = $("#c_password").val();

                if (password !== c_password) {
                    $("#alert_msg").show().text('Passwords do not match.');
                    return;
                }
                if (password.length < 8) {
                    $("#alert_msg").show().text('Password must be at least 8 characters long.');
                    return;
                }

                $.ajax({
                    url: 'backend/api/user-auth-api.php?action=NewPass', // Adjust this URL to your API endpoint
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        token: token,
                        new_password: password
                    }),
                    beforeSend: function() {
                        $("#submit").prop('disabled', true);
                        $("#submit").text('Loading...');
                    },
                    success: function(response) {
                        if (response.status === 'true') {
                            showMsg('success', response.message)
                            $("#submit").text('Done');
                            setTimeout(function() {
                                window.location.href = 'login.php'; // Redirect to login page
                            }, 2000);
                        } else if (response.message === 'Invalid or expired token') {
                            showMsg('error', response.message)
                            setTimeout(function() {
                                window.location.href = 'login.php'; // Redirect to login page
                            }, 1600);
                        } else {
                            $("#alert_msg").show().text(response.message);
                            $("#submit").prop('disabled', false);
                            $("#submit").text('Submit');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        showMessage('error', textStatus)
                    }
                });

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
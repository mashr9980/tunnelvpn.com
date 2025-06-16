<?php
session_start();

if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] != 'admin') {
    header("Location: index.php");
}
if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] != 'admin') {
    header("Location: index.php");
}

include_once 'backend/controller/config.php';
include_once 'include/head.php';
function old($key)
{
    return isset($_SESSION['oldData'][$key]) ? htmlspecialchars($_SESSION['oldData'][$key]) : '';
}

$token = isset($_GET['token']) ? $_GET['token'] : '';
?>



<body>
    <!--authentication-->

    <div class="mx-3 mx-lg-0">

        <div class="card my-5 col-xl-6 col-xxl-6 mx-auto rounded-4 overflow-hidden p-4">
            <div class="row g-4">
                <div class="col-lg-12 d-flex">
                    <div class="card-body">
                        <img src="assets/images/logo1.png" class="mb-4" width="145" alt="">
                        <h4 class="fw-bold">Change Password Now</h4>
                        <p class="mb-3">Enter your New Password to login into Admin Panel</p>

                        <div class="separator">
                            <div class="line"></div>
                            <p class="mb-0 fw-bold">OR</p>
                            <div class="line"></div>
                        </div>
                        <div class="form-body mt-4">
                            <form class="row g-3" method="post" id="reset-password-form">
                                <input type="hidden" value="<?php echo $token ?>" name="token" id="token">
                                <div class="col-12">
                                    <label for="new_password" class="form-label">Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password" class="form-control border-end-0" name="password" id="new_password">
                                        <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password" class="form-control border-end-0" name="password_confirm" id="confirm_password">
                                        <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" name="loginuser" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-info">
                                            <a href="login.php" class="text-light">
                                                Return to Login</a></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div><!--end row-->
        </div>

    </div>




    <!--authentication-->


    <?php
    unset($_SESSION['oldData']);
    ?>


    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#reset-password-form').on('submit', function(event) {
                event.preventDefault();

                var token = $('#token').val();
                var newPassword = $('#new_password').val();
                var confirmPassword = $('#confirm_password').val();

                if (newPassword !== confirmPassword) {
                    showMessage('error', 'Passwords do not match.')
                    return;
                }
                if (newPassword.length < 8) {
                    showMessage('error', 'Password must be at least 8 characters long.')
                    return;
                }

                $.ajax({
                    url: 'backend/api/user-auth-api.php?action=NewPass', // Adjust this URL to your API endpoint
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        token: token,
                        new_password: newPassword
                    }),
                    success: function(response) {
                        // console.log(response);
                        if (response.status === 'true') {
                            showMessage('success', response.message)
                            setTimeout(function() {
                                window.location.href = 'login.php'; // Redirect to login page
                            }, 2000);
                        } else {
                            showMessage('error', response.message)
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        showMessage('error', textStatus)
                    }
                });
            });

            function showMessage(type, msg) {
                Swal.fire({
                    text: msg,
                    icon: type
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password i').removeClass("bi-eye-fill");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password i').addClass("bi-eye-fill");
                }
            });
        });
    </script>

</body>

</html>
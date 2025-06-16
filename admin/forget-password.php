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
?>



<body>
    <!--authentication-->

    <div class="mx-3 mx-lg-0">

        <div class="card my-5 col-xl-9 col-xxl-8 mx-auto rounded-4 overflow-hidden p-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 d-flex">
                    <div class="card-body">
                        <img src="assets/images/logo1.png" class="mb-4" width="145" alt="">
                        <h4 class="fw-bold">Forgot Password?</h4>
                        <p class="mb-0">Enter your registered email ID to reset the password</p>

                        <div class="form-body mt-4">
                            <form class="row g-3" method="post" id="reset-password-form">
                                <div class="col-12">
                                    <label class="form-label">Email id</label>
                                    <input type="text" id="email" name="email" class="form-control" placeholder="example@user.com">
                                </div>
                                <div class="col-12">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                        <a href="login.php" class="btn btn-light">Back to Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 d-lg-flex d-none">
                    <div class="p-3 rounded-4 w-100 d-flex align-items-center justify-content-center bg-light">
                        <img src="assets/images/auth/forgot-password1.png" class="img-fluid" alt="">
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

                var email = $('#email').val();

                $.ajax({
                    url: 'backend/api/user-auth-api.php?action=forgotpass', // Adjust this URL to your API endpoint
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        email: email
                    }),
                    success: function(response) {
                        console.log(response);
                        // if (response.status === true) {
                        //     showMessage('success', response.message)
                        // } else {
                        //     showMessage('error', response.message)
                        // }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        showMessage('info', textStatus)
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
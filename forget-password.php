<?php
session_start();

if (isset($_SESSION['login_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TunnelVPN</title>
    <link rel="stylesheet" href="dist/iofrm-style.css">
    <link rel="stylesheet" href="dist/iofrm-theme.css">
    <link rel="stylesheet" href="dist/payment.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light-grey">
    <div class="preloader js-preloader ">
        <span class="preloader__circle preloader__circle--primary"></span>
        <span class="preloader__circle preloader__circle--secondary"></span>
        <span class="preloader__circle preloader__circle--tertiary"></span>
    </div>

    <?php include('include/guest_navbar.php'); ?>

    <div class="form-body without-side" style="background: inherit;">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Password Reset</h3>
                        <p>To reset your password, enter the email address you use to sign in to TunnelVPN</p>
                        <form>
                            <input class="form-control" type="text" name="email" placeholder="E-mail Address" id="email" required>
                            <div class="form-button full-width">
                                <button id="submit" type="submit" class="ibtn btn-forget">Send Reset Link</button>
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
            $("#alert_msg").hide();
            $("#submit").on('click', function(e) {
                e.preventDefault();
                var email = $("#email").val();

                // emptyfield validation
                if (email == '') {
                    $("#alert_msg").show().text("Please enter your email");
                    return false;
                }

                $.ajax({
                    url: 'backend/api/user-auth-api.php?action=forgotpass',
                    type: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        email: email
                    }),
                    beforeSend: function() {
                        $("#submit").prop('disabled', true);
                        $("#submit").text('Loading...');
                    },
                    success: function(response) {
                        console.log(response);

                        if (response.status == true) {
                            showMsg('success', response.message)
                            $("#submit").text('Done');
                        } else {
                            $("#alert_msg").show().text(response.message);
                            $("#submit").prop('disabled', false);
                            $("#submit").text('Submit');
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
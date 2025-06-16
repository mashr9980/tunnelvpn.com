<?php
session_start();

if (isset($_SESSION['login_id'])) {
    header("Location: index.php");
    exit();
}

require_once __DIR__ . '/backend/mail/mailer.php';
require_once __DIR__ . '/backend/controller/config.php';

if (isset($_POST['resend_verification'])) {
    $email = $_POST['email'];
    $user = $crud->select('users', '*', null, "(`email` = ? OR `username`=?) AND `is_verified` = ? ", array($email, $email, 0));
    if (is_array($user)) {
        $user_id = $user['user_id'];
        $verification_token = bin2hex(random_bytes(16));
        $updateData = array('verification_token' => $verification_token);
        $NewToken = $crud->update('users', $updateData, "`user_id`=$user_id");
        if ($NewToken) {
            $reset_link = $Site . '/verify.php?token=' . $verification_token;
            if (sendMail($email, $reset_link, 'Verify Email', null, $user['username'], null, true)) {
                $_SESSION['message'] = 'A new verification email has been sent.';
            } else {
                $_SESSION['message'] = 'Error sending verification email.';
            }
        }
    } else {
        $_SESSION['message'] = 'No account found with this email or the account is already verified. Try to Login';
    }
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
                        <h3>Verify Email</h3>
                        <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                        <form method="post">
                            <input class="form-control" type="text" name="email" placeholder="E-mail Address" required>
                            <div class="form-button full-width">
                                <button id="submit" type="submit" name="resend_verification" class="ibtn btn-forget">Send Reset Link</button>
                            </div>
                        </form>
                        <?php if (isset($_SESSION['message'])) : ?>
                            <p class="mt-3 mb-0 pb-0">
                                <?php echo $_SESSION['message'];
                                unset($_SESSION['message']); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
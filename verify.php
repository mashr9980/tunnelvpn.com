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
require_once __DIR__ . '/backend/controller/config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $user = $crud->select('users', '*', null, "`verification_token`=?", array($token));
    if (is_array($user)) {
        $user_id = $user['user_id'];
        $updateData = array('is_verified' => 1, 'verification_token' => null);
        $VerifyUser = $crud->update('users', $updateData, "`user_id`=$user_id");
        $_SESSION['message'] = 'Your email has been verified successfully. You can now log in. Redirecting you back to login in 3 seconds';
        header("Refresh:3; url=login.php", true, 303);
    } else {
        $_SESSION['message'] = 'Invalid verification token. Redirecting you back to login in 3 seconds';
        header("Refresh:3; url=login.php", true, 303);
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

    <div class="form-body without-side">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
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
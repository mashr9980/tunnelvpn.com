<?php
session_start();

if (!isset($_SESSION['login_id'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['payment_success']) || $_SESSION['payment_success'] !== true) {
    header("Location: index.php"); // Redirect to the homepage or any other page
    exit();
}
require 'vendor/autoload.php';
include_once 'backend/controller/config.php';


// Retrieve transaction details from the session
$transaction_id = htmlspecialchars($_SESSION['transaction_id']);
$plan = htmlspecialchars($_SESSION['plan']);
$receipt_email = htmlspecialchars($_SESSION['receipt_email']);
$user_id = $_SESSION['login_id'];

switch ($plan) {
    case 'standard_monthly':
        $expire_date = date('Y-m-d h:i:s A', strtotime('+1 month'));
        $planname = '1-Month';
        $singleCharge = 12.95;
        $duration = 1;
        $totalCharge = 1295;
        break;
    case 'standard_halfyear':
        $planname = '6-Month';
        $expire_date = date('Y-m-d h:i:s A', strtotime('+6 months'));
        $totalCharge = 5994;
        $duration = 6;
        $singleCharge = 9.99;
        break;
    case 'premium_yearly':
        $expire_date = date('Y-m-d h:i:s A', strtotime('+1 year'));
        $planname = '12-Month';
        $singleCharge = 6.67;
        $duration = 12;
        $totalCharge = 8004;
        break;
}

if (isset($_SESSION['dedicated_status']) && $_SESSION['dedicated_status'] == true) {
    $dedicatedIpChargePerMonth = 419;
    $dedicatedIpTotalCharge = $dedicatedIpChargePerMonth * $duration;
    $totalCharge += $dedicatedIpTotalCharge;
    $planname .= ' + Dedicated IP';

    $dedicated = $crud->select('dedicated_ip', '*', null, "`user_id`=?", array($user_id));
    if (is_array($dedicated)) {
        $data = array(
            'city' => $_SESSION['dedicated_city'],
            'country' => $_SESSION['dedicated_country']
        );
        $update = $crud->update('dedicated_ip', $data, "`user_id`=$user_id");
    } else {
        $data = array(
            'user_id' => $user_id,
            'city' => $_SESSION['dedicated_city'],
            'country' => $_SESSION['dedicated_country']
        );
        $saveIP = $crud->insert('dedicated_ip', $data);
    }

    unset($_SESSION['dedicated_city']);
    unset($_SESSION['dedicated_country']);
}

$userToken = $crud->select('users', 'remember_token', null, "`user_id`=?", array($user_id));

if (empty($userToken['remember_token'])) {
    $Updatedata = array(
        'remember_token' => bin2hex(random_bytes(6))
    );
    $saveToken = $crud->update('users', $Updatedata, "`user_id`=$user_id");
    $userToken['remember_token'] = $Updatedata['remember_token'];
}

$data = array(
    'token' => $userToken['remember_token'], // Replace with your authentication token or method
    'status' => 'true', // Adjust as per your payment flow
    'expiry_date' => "$expire_date"
);
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

    <div class="main-container pb-4 mt-1">
        <div class="container">
            <div class="row row-gap-4 align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="summary-head">
                                <h2>Purchase Summary</h2>
                            </div>
                            <div class="summary-body">
                                <div class="d-flex align-items-center justify-content-between ">
                                    <p><?php echo $planname; ?> Plan</p>
                                    <p>$<?php echo $singleCharge ?>/month</p>
                                </div>
                                <?php
                                if (isset($_SESSION['dedicated_status']) && $_SESSION['dedicated_status'] == true) {
                                    echo '<div class="d-flex align-items-center justify-content-between b-bottm">
                                <p>Dedicated IP</p>
                                <p>$' . number_format($dedicatedIpTotalCharge / 100, 2) . '</p>
                            </div>';
                                }
                                ?>
                                <div class="d-flex align-items-start justify-content-center flex-column row-gap-1">
                                    <p><strong>Transaction ID: </strong><?php echo $transaction_id; ?></p>
                                    <p>Receipt Email: <?php echo $receipt_email; ?></p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between b-bottm">
                                    <p><strong>Amount Charged:</strong></p>
                                    <p class="price">$<?php echo number_format($totalCharge / 100, 2); ?></p>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <p class="details">Payment Status: Successful</p>
                                <p><strong>Account:</strong> <?php echo $_SESSION['user_email']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'backend/api/purchase-api.php?action=NewPurchase',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(<?php echo json_encode($data); ?>),
                success: function(response) {
                    // console.log(response);
                    // Handle API response
                    if (response.status === 'success') {
                        // Purchase details saved successfully
                        showMsg('success', 'Purchased successfully')
                    } else {
                        // Handle API error response
                        var error_message = 'Failed to save purchase details: ' + response.message;
                        console.log(response);
                        showMsg('error', error_message)
                        // You may log the error or handle it as per your application's error handling strategy
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                    var error_message = 'AJAX error: ' + error;
                    showMsg('info', error_message)
                }
            });

            function showMsg(type, msg) {
                Swal.fire({
                    text: msg,
                    icon: type
                });
            }
        });
    </script>
</body>

</html>
<?php
unset($_SESSION['payment_success']);
unset($_SESSION['transaction_id']);
unset($_SESSION['plan']);
unset($_SESSION['receipt_email']);
unset($_SESSION['dedicated_status']);
?>
<?php
session_start();

if (!isset($_POST['transaction_id']) || !isset($_POST['plan']) || !isset($_POST['receipt_email'])) {
    http_response_code(400);
    exit('Invalid request');
}

$_SESSION['payment_success'] = true;
$_SESSION['transaction_id'] = $_POST['transaction_id'];
$_SESSION['plan'] = $_POST['plan'];
$_SESSION['receipt_email'] = $_POST['receipt_email'];

http_response_code(200);
exit('Success');

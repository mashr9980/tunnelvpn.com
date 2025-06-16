<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['login_id'])) {
    // Redirect to login page
    header("Location: login.php?redirect=buy.php&plan=" . $_GET['plan']);
    exit();
}

// User is logged in, redirect to checkout form
header("Location: payment.php?plan=" . $_GET['plan']);
exit();

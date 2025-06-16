<?php
session_start();
if (isset($_POST['action']) && $_POST['action'] == 'savetime') {
    $_SESSION['timezone'] = $_POST['timezone'];
    echo true;
}


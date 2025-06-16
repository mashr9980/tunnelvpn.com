<?php
session_start();

include_once '../controller/config.php';
include_once '../controller/prepare-crud.php';

if (isset($_POST['createpromo'])) {
    $data = $_POST;
    unset($data['createpromo']);

    $requiredfields = array('code', 'expiration_date');
    $checkdata = $crud->validateMissing($data, $requiredfields);
    if (!empty($checkdata)) {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage($checkdata, 'error', '../../add-promo-code.php');
        exit;
    }

    $checkPromo = $crud->select('promo_codes', 'promo_id', null, "`code`=?", array($data['code']));
    if (is_array($checkPromo)) {
        $_SESSION['oldData'] = $data;
        $crud->displayMessage('Promo code already exists', 'error', '../../add-promo-code.php');
        exit;
    }

    $addPromo = $crud->insert('promo_codes', $data);
    if (is_bool($addPromo)) {
        $crud->displayMessage('Promo code added successfully', 'success', '../../all-promo-codes.php');
    } else {
        $crud->displayMessage($addPromo, 'error', '../../add-promo-code.php');
    }
}

if (isset($_POST['updatepromo'])) {
    $data = $_POST;
    unset($data['updatepromo']);
    $promo_id = $_POST['promo_id'];

    $requiredfields = array('code', 'expiration_date');
    $checkdata = $crud->validateMissing($data, $requiredfields);
    if (!empty($checkdata)) {
        $crud->displayMessage($checkdata, 'error', '../../edit-promo-code.php?promo_id=' . $promo_id);
        exit;
    }

    $checkPromo = $crud->select('promo_codes', 'promo_id', null, "`code`=?", array($data['code']));
    if (is_array($checkPromo) && $checkPromo['promo_id'] != $data['promo_id']) {
        $crud->displayMessage('Promo code already exists', 'error', '../../edit-promo-code.php?promo_id=' . $promo_id);
        exit;
    }

    unset($data['promo_id']);
    $updatePromo = $crud->update('promo_codes', $data, "`promo_id`=$promo_id");
    if (is_bool($updatePromo)) {
        $crud->displayMessage('Promo code updated successfully', 'success', '../../all-promo-codes.php');
    } else {
        $crud->displayMessage($updatePromo, 'info', '../../all-promo-code.php');
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'deletepromo') {
    $promo_id = $_GET['promo_id'];
    $deletePromo = $crud->delete('promo_codes', "`promo_id`=?", array($promo_id));
    if (is_bool($deletePromo)) {
        $crud->displayMessage('Promo code deleted successfully', 'success', '../../all-promo-codes.php');
    } else {
        $crud->displayMessage($deletePromo, 'error', '../../all-promo-codes.php');
    }
}

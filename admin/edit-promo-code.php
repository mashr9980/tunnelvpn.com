<?php
session_start();
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != true) {
    header("Location: login.php");
}
if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] == 'admin') {
    header("Location: login.php");
}
if (!isset($_GET['promo_id'])) {
    header("Location: all-promo-codes.php");
}

include_once 'backend/controller/config.php';
include_once 'include/head.php';
function old($key)
{
    return isset($_SESSION['oldData'][$key]) ? $_SESSION['oldData'][$key] : '';
}
?>

<?php
include_once 'include/header.php';
?>

<?php
include_once 'include/sidebar.php';

$promo_id = $_GET['promo_id'];
$getPromo = $crud->select('promo_codes', '*', null, '`promo_id`=?', array($promo_id));
if (is_array($getPromo)) {
?>
    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Edit Promo Code</h5>
                            <form class="row g-3" method="post" action="backend/manager/promo-manage.php">
                                <div class="col-md-12">
                                    <label for="input1" class="form-label">Code</label>
                                    <input type="hidden" class="form-control" id="input1" name="promo_id" value="<?php echo $getPromo['promo_id'] ?>" required>
                                    <input type="text" class="form-control" id="input1" name="code" value="<?php echo $getPromo['code'] ?>" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="input1" class="form-label">Expiration Date</label>
                                    <input type="text" class="form-control date-time flatpickr-input" name="expiration_date" value="<?php echo $getPromo['expiration_date'] ?>" required readonly="readonly">
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" name="updatepromo" class="btn btn-primary px-4">Update</button>
                                        <button type="button" class="btn btn-light px-4">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php } else {
    echo '
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">No promo code found</h5>
                            <a href="all-promo-codes.php">Go Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    ';
}
?>
<!--end main wrapper-->

<?php
unset($_SESSION['oldData']);
include_once 'include/footer.php';
?>
<?php
session_start();
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != true) {
    header("Location: login.php");
}
if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] == 'admin') {
    header("Location: login.php");
}

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
?>
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Add New Server</h5>
                        <form class="row g-3" method="post" action="backend/manager/server-manage.php" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <label for="input13" class="form-label">Server Name</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="input13" value="<?= htmlspecialchars(old('server_name')) ?>" name="server_name" placeholder="Server Name">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="input14" class="form-label">Server Image</label>
                                <input type="file" class="form-control" id="input14" multiple name="server_img">
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-switch form-check-info">
                                    <input class="form-check-input" type="checkbox" name="status" <?= old('status') ? 'checked' : '' ?> role="switch" id="flexSwitchCheckInfo">
                                    <label class="form-check-label" for="flexSwitchCheckInfo">Premium</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" name="createserver" class="btn btn-primary px-4">Create</button>
                                    <button type="button" class="btn btn-light px-4">Reset</button>
                                </div>
                            </div>
                            <p class="mb-0">Make sure the img is 200x200 pixels. Max Width should be 200px</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--end main wrapper-->

<?php
unset($_SESSION['oldData']);
include_once 'include/footer.php';
?>
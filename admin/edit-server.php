<?php
session_start();

if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != true) {
    header("Location: login.php");
}
if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] == 'admin') {
    header("Location: login.php");
}
if (!isset($_GET['server_id'])) {
    header("Location: all-server.php");
}

include_once 'include/head.php';
include_once 'backend/controller/config.php';

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
$getServer = $crud->select('servers', '*', null, "`server_id`=?", array($_GET['server_id']));
if (is_array($getServer)) {
?>
    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Edit Server</h5>
                            <form class="row g-3" method="post" action="backend/manager/server-manage.php" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <label for="input13" class="form-label">Server Name</label>
                                    <div class="position-relative input-icon">
                                        <input type="hidden" class="form-control" id="input1" value="<?php echo $getServer['server_id'] ?>" name="server_id">
                                        <input type="text" class="form-control" id="input13" value="<?php echo $getServer['server_name'] ?>" name="server_name" placeholder="Server Name">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="input14" class="form-label">Old Image</label>
                                    <img src="upload-img/server-img/<?php echo $getServer['server_img'] ?>" class="rounded-circle p-1 border" width="50px" alt="">
                                </div>
                                <div class="col-md-12">
                                    <label for="input14" class="form-label">Server Image</label>
                                    <input type="hidden" class="form-control" id="input14" value="<?php echo $getServer['server_img'] ?>" name="old_server_img">
                                    <input type="file" class="form-control" id="input14" name="new_server_img">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-switch form-check-info">
                                        <input class="form-check-input" type="checkbox" name="status" <?php echo $getServer['status'] == 1 ? 'checked' : '' ?> role="switch" id="flexSwitchCheckInfo">
                                        <label class="form-check-label" for="flexSwitchCheckInfo">Premium</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" name="updateserver" class="btn btn-primary px-4">Update</button>
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
<?php } else {
    echo '
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">No Server found</h5>
                            <a href="all-server.php">Go Back</a>
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
unset($_SESSION['old']);
include_once 'include/footer.php';
?>
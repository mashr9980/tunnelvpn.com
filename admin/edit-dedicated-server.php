<?php
session_start();
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != true) {
    header("Location: login.php");
}
if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] == 'admin') {
    header("Location: login.php");
}

if (!isset($_GET['id'])) {
    header("Location: dedicated-users.php");
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
include_once 'backend/controller/config.php';
$id = $_GET['id'];

$dedicated = $crud->select('dedicated_servers', '*', null, "`id`=?", array($id));
if (is_array($dedicated)) {
?>
    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Edit Dedicated Server</h5>
                            <form class="row g-3" method="post" action="backend/manager/dedicated-server.php" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <div class="d-flex flex-row align-items-center justify-content-between">
                                        <label for="input14" class="form-label">Old Image</label>
                                        <img src="upload-img/dedicated-server/<?php echo $dedicated['server_img'] ?>" class="p-1 border rounded-circle" width="90">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="server_name" class="form-label">Server Name</label>
                                    <input type="hidden" value="<?php echo $dedicated['id'] ?>" name="id">
                                    <input type="text" class="form-control" id="server_name" name="server_name" value="<?php echo $dedicated['server_name'] ?>" required placeholder="Server Name">
                                </div>
                                <div class="col-md-12">
                                    <label for="server_city" class="form-label">Server City</label>
                                    <input type="text" class="form-control" id="server_city" name="server_city" value="<?php echo $dedicated['server_city'] ?>" required placeholder="Server City">
                                </div>
                                <div class="col-md-12">
                                    <label for="server_img" class="form-label">New Server Image</label>
                                    <input type="hidden" class="form-control" id="input14" value="<?php echo $dedicated['server_img'] ?>" name="old_server_img">
                                    <input type="file" class="form-control" id="server_img" name="new_server_img">
                                    <small>If You Uploaded New Image, the Previous Img Would be Deleted</small>
                                </div>
                                <div class="col-md-12">
                                    <label for="server_address" class="form-label">Server Address</label>
                                    <input type="text" class="form-control" id="server_address" name="server_address" value="<?= $dedicated['server_address'] ?>" required placeholder="Server Address">
                                </div>
                                <div class="col-md-12">
                                    <label for="input1" class="form-label">Longitude</label>
                                    <input type="text" class="form-control" id="input1" name="longitude" value="<?php echo $dedicated['longitude'] ?>" required placeholder="Longitude">
                                </div>
                                <div class="col-md-12">
                                    <label for="input1" class="form-label">Latitude</label>
                                    <input type="text" class="form-control" id="input1" name="latitude" value="<?php echo $dedicated['latitude'] ?>" required placeholder="Latitude">
                                </div>
                                <div class="col-md-12">
                                    <label for="server_config" class="form-label">Sub Server Config</label>
                                    <textarea cols="40" rows="5" class="form-control" id="server_config" name="server_config" required placeholder="Server Config"><?= $dedicated['server_config'] ?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" name="updateDedserver" class="btn btn-primary px-4">Update</button>
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
                            <h5 class="mb-4">No User found</h5>
                            <a href="dedicated-users.php">Go Back</a>
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
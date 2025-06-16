<?php
session_start();

if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != true) {
    header("Location: login.php");
}
if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] == 'admin') {
    header("Location: login.php");
}
if (!isset($_GET['sub_server_id'])) {
    header("Location: all-sub-server.php");
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
$getservers = $crud->select('servers', 'server_id,server_name');

$getSubServer = $crud->select('sub_servers', '*', null, "`sub_server_id`=?", array($_GET['sub_server_id']));

if (is_array($getSubServer)) {
?>
    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Edi Sub Server</h5>
                            <form class="row g-3" method="post" action="backend/manager/sub-server-manage.php">
                                <div class="col-md-12">
                                    <label for="input7" class="form-label">Main Server</label>
                                    <select id="input7" class="form-select" name="server_id">
                                        <option selected disabled>Select Server</option>
                                        <?php
                                        if (is_array($getservers)) {
                                            if (isset($getservers[0])) {
                                                foreach ($getservers as $server) {
                                        ?>
                                                    <option value="<?php echo $server['server_id'] ?>" <?php echo ($getSubServer['server_id'] == $server['server_id']) ? 'selected' : '' ?>><?php echo $server['server_name'] ?></option>
                                                <?php
                                                }
                                            } else {
                                                $server = $getservers;
                                                ?>
                                                <option value="<?php echo $server['server_id'] ?>" <?php echo ($getSubServer['server_id'] == $server['server_id']) ? 'selected' : '' ?>><?php echo $server['server_name'] ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option selected disabled>No Server Found</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div>






                                    </div>
                                    <div class="col-md-12">
                                        <label for="input1" class="form-label">Sub Server Name</label>
                                        <input type="hidden" class="form-control" value="<?php echo $getSubServer['sub_server_id'] ?>" name="sub_server_id">
                                        <input type="text" class="form-control" id="input1" name="sub_server_name" value="<?php echo $getSubServer['sub_server_name'] ?>" required placeholder="Sub Server Name">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="input1" class="form-label">IP Address</label>
                                        <input type="text" class="form-control" cols="40" rows="5" id="input1" name="ip_addresss" value="<?php echo $getSubServer['ip_addresss'] ?>" required placeholder="IP Address">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="input1" class="form-label">Longitude</label>
                                        <input type="text" class="form-control" id="input1" name="longitude" value="<?php echo $getSubServer['longitude'] ?>" required placeholder="Longitude">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="input1" class="form-label">Latitude</label>
                                        <input type="text" class="form-control" id="input1" name="latitude" value="<?php echo $getSubServer['latitude'] ?>" required placeholder="Latitude">
                                    </div>
                                    <div class="col-md-12">
                                    <label for="input1" class="form-label">Panel Address</label>
                                    <input type="text" class="form-control" name="panel_address" value="<?php echo $getSubServer['panel_address'] ?>" required placeholder="Panel Address">
                                </div>
                                <div class="col-md-12">
                                    <label for="input1" class="form-label">Password</label>
                                    <input type="text" class="form-control" name="password" value="<?php echo $getSubServer['password'] ?>" required placeholder="Password">
                                </div>
                                    <div class="col-md-12">
                                        <label for="input1" class="form-label">Sub Server Config</label>
                                        <textarea cols="40" rows="5" class="form-control" id="input1" name="sub_server_config" value="<?php echo $getSubServer['sub_server_config'] ?>" required placeholder="Sub Server Config"><?php echo $getSubServer['sub_server_config'] ?></textarea>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" name="updatesubserver" class="btn btn-primary px-4">Update</button>
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
                            <h5 class="mb-4">No Sub Server found</h5>
                            <a href="all-sub-server.php">Go Back</a>
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
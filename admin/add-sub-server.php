<?php
session_start();
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != true) {
    header("Location: login.php");
}
if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] == 'admin') {
    header("Location: login.php");
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
$getservers = $crud->select('servers', 'server_id,server_name,status');
?>
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Add Sub Server</h5>
                        <form class="row g-3" method="post" action="backend/manager/sub-server-manage.php">
                            <div class="col-md-12">
                                <label for="input7" class="form-label">Main Server</label>
                                <select id="input7" class="form-select" name="server_id" required>
                                    <option selected disabled>Select Server</option>
                                    <?php
                                    if (is_array($getservers)) {
                                        if (isset($getservers[0])) {
                                            foreach ($getservers as $server) {
                                                print_r($server);
                                    ?>
                                                <option value="<?php echo $server['server_id'] ?>"><?php echo $server['server_name'] ?> - <?php
                                                                                                                                            if ($server['status'] == '1') {
                                                                                                                                                echo 'Premium';
                                                                                                                                            } else {
                                                                                                                                                echo 'Free';
                                                                                                                                            }
                                                                                                                                            ?></option>
                                            <?php
                                            }
                                        } else {
                                            $server = $getservers;
                                            ?>
                                            <option value="<?php echo $server['server_id'] ?>"><?php echo $server['server_name'] ?><?php echo $server['status'] ?></option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option selected disabled>No Server Found</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="input1" class="form-label">Sub Server Name</label>
                                <input type="text" class="form-control" id="input1" name="sub_server_name" value="<?= old('sub_server_name') ?>" required placeholder="Sub Server Name">
                            </div>
                            <div class="col-md-12">
                                <label for="input1" class="form-label">IP Address</label>
                                <input type="text" class="form-control" cols="40" rows="5" id="input1" name="ip_addresss" value="<?= old('ip_addresss') ?>" required placeholder="IP Address">
                            </div>
                            <div class="col-md-12">
                                <label for="input1" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="input1" name="longitude" value="<?= old('longitude') ?>" required placeholder="Longitude">
                            </div>
                            <div class="col-md-12">
                                <label for="input1" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="input1" name="latitude" value="<?= old('latitude') ?>" required placeholder="Latitude">
                            </div>
                            <div class="col-md-12">
                                    <label for="input1" class="form-label">Panel Address</label>
                                    <input type="text" class="form-control" name="panel_address" value="<?= old('panel_address') ?>" required placeholder="Panel Address">
                                </div>
                                <div class="col-md-12">
                                    <label for="input1" class="form-label">Password</label>
                                    <input type="text" class="form-control" name="password" value="<?= old('password') ?>" required placeholder="Password">
                                </div>
                            <div class="col-md-12">
                                <label for="input1" class="form-label">Sub Server Config</label>
                                <textarea cols="40" rows="5" class="form-control" id="input1" name="sub_server_config" value="<?= old('sub_server_config') ?>" required placeholder="Sub Server Config"></textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" name="createsubserver" class="btn btn-primary px-4">Create</button>
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
<!--end main wrapper-->

<?php
unset($_SESSION['oldData']);
include_once 'include/footer.php';
?>
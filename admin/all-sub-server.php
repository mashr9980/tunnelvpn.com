<?php
session_start();

if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != true) {
    header("Location: login.php");
}
if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] == 'admin') {
    header("Location: login.php");
}
include_once 'include/head.php';
include_once 'backend/controller/config.php';
?>

<?php
include_once 'include/header.php';
?>

<?php
include_once 'include/sidebar.php';
?>

<?php
$getServers = $crud->select('sub_servers', 'sub_servers.*, servers.server_name as server_name, servers.status as status', 'JOIN servers ON sub_servers.server_id = servers.server_id');

?>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row g-3">

            <div class="col-auto flex-grow-1">
                <h3 class="mb-0">All Sub Servers</h3>
            </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <a href="add-sub-server.php">
                        <button class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>Add Sub Server</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%; vertical-align:middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Server</th>
                                <th>Name</th>
                                <th>Config</th>
                                <th>IP Address</th>
                                <th>Longitude</th>
                                <th>Latitude</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($getServers)) {
                                $i = 1;
                                if (isset($getServers[0])) {
                                    foreach ($getServers as $server) {

                            ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $server['server_name'] ?>  -  <?php 
                                                if($server['status'] == '1'){
                                                    echo 'Premium';
                                                }else{
                                                    echo 'Free';
                                                }
                                                ?></td>
                                            <td><?php echo $server['sub_server_name'] ?></td>
                                            <td><?php echo substr($server['sub_server_config'], 0, 100) . '...' ?></td>
                                            <td><?php echo $server['ip_addresss'] ?></td>
                                            <td><?php echo $server['longitude'] ?></td>
                                            <td><?php echo $server['latitude'] ?></td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($server['created_at'])); ?></td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($server['updated_at'])); ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="edit-sub-server.php?sub_server_id=<?php echo $server['sub_server_id'] ?>">
                                                        <button type="button" class="btn btn-info raised d-flex gap-2"><i class="material-icons-outlined">edit</i></button>
                                                    </a>
                                                    <a href="backend/manager/sub-server-manage.php?action=deletesubserver&sub_server_id=<?php echo $server['sub_server_id'] ?>">
                                                        <button type="button" class="btn btn-dark raised d-flex gap-2"><i class="material-icons-outlined">delete</i></button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } else {
                                    $server = $getServers;
                                    ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $server['server_name'] ?>  -  <?php 
                                                if($server['status'] == '1'){
                                                    echo 'Premium';
                                                }else{
                                                    echo 'Free';
                                                }
                                                ?></td>
                                        <td><?php echo $server['sub_server_name'] ?></td>
                                        <td><?php echo substr($server['sub_server_config'], 0, 100) . '...' ?></td>
                                        <td><?php echo $server['ip_addresss'] ?></td>
                                        <td><?php echo date('d-m-Y h:i a', strtotime($server['created_at'])); ?></td>
                                        <td><?php echo date('d-m-Y h:i a', strtotime($server['updated_at'])); ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="edit-sub-server.php?sub_server_id=<?php echo $server['sub_server_id'] ?>">
                                                    <button type="button" class="btn btn-info raised d-flex gap-2"><i class="material-icons-outlined">edit</i></button>
                                                </a>
                                                <a href="backend/manager/sub-server-manage.php?action=deletesubserver&sub_server_id=<?php echo $server['sub_server_id'] ?>">
                                                    <button type="button" class="btn btn-dark raised d-flex gap-2"><i class="material-icons-outlined">delete</i></button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            <?php
                            } else {
                            ?>
                                <tr>
                                    <td colspan="7" class="text-center">No Sub Server Found</td>
                                </tr>
                            <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<!--end main wrapper-->

<?php
include_once 'include/footer.php';
?>
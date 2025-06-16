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

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $getServers = $crud->select(
        'dedicated_servers',
        'dedicated_servers.*, users.username, users.email',
        'JOIN dedicated_ip ON dedicated_servers.dedicated_ip_id = dedicated_ip.id JOIN users ON dedicated_ip.user_id = users.user_id',
        'users.user_id = ?',
        array($user_id)
    );
} else {
    $getServers = $crud->select('dedicated_servers', 'dedicated_servers.*, users.username, users.email', 'JOIN dedicated_ip ON dedicated_servers.dedicated_ip_id = dedicated_ip.id JOIN users ON dedicated_ip.user_id = users.user_id');
}
?>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row g-3">
            <div class="col-auto flex-grow-1">
                <h3 class="mb-0">All Dedicated Servers</h3>
            </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <?php
                    if (isset($_GET['user_id'])) {
                        echo '<a href="add-dedicated-server.php?user_id=' . $user_id . '">
                        <button class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>Add Dedicated Server</button>
                    </a>';
                    }
                    ?>
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
                                <th>Image</th>
                                <th>User</th>
                                <th>Server</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Longitude</th>
                                <th>Latitude</th>
                                <th>Config</th>
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
                                            <td>
                                                <img src="upload-img/dedicated-server/<?php echo $server['server_img'] ?>" width="50px" alt="">
                                            </td>
                                            <td>Name: <?php echo $server['username'] ?><br>Email: <?php echo $server['email'] ?></td>
                                            <td><?php echo $server['server_name'] ?></td>
                                            <td><?php echo $server['server_city'] ?></td>
                                            <td><?php echo substr($server['server_address'], 0, 30) . '...' ?></td>
                                            <td><?php echo $server['longitude'] ?></td>
                                            <td><?php echo $server['latitude'] ?></td>
                                            <td><?php echo substr($server['server_config'], 0, 30) . '...' ?></td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($server['created_at'])); ?></td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($server['updated_at'])); ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="edit-dedicated-server.php?id=<?php echo $server['id'] ?>">
                                                        <button type="button" class="btn btn-info raised d-flex gap-2"><i class="material-icons-outlined">edit</i></button>
                                                    </a>
                                                    <a href="backend/manager/dedicated-server.php?id=<?php echo $server['id'] ?>">
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
                                        <td>
                                            <img src="upload-img/dedicated-server/<?php echo $server['server_img'] ?>" width="50px" alt="">
                                        </td>
                                        <td>Name: <?php echo $server['username'] ?><br>Email: <?php echo $server['email'] ?></td>
                                        <td><?php echo $server['server_name'] ?></td>
                                        <td><?php echo $server['server_city'] ?></td>
                                        <td><?php echo substr($server['server_address'], 0, 30) . '...' ?></td>
                                        <td><?php echo $server['longitude'] ?></td>
                                        <td><?php echo $server['latitude'] ?></td>
                                        <td><?php echo substr($server['server_config'], 0, 30) . '...' ?></td>
                                        <td><?php echo date('d-m-Y h:i a', strtotime($server['created_at'])); ?></td>
                                        <td><?php echo date('d-m-Y h:i a', strtotime($server['updated_at'])); ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="edit-dedicated-server.php?id=<?php echo $server['id'] ?>">
                                                    <button type="button" class="btn btn-info raised d-flex gap-2"><i class="material-icons-outlined">edit</i></button>
                                                </a>
                                                <a href="backend/manager/dedicated-server.php?id=<?php echo $server['id'] ?>">
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
                                    <td colspan="10" class="text-center">No Dedicated Server Found</td>
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
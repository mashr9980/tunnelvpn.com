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
$getUsers = $crud->select('users', 'users.*, dedicated_ip.city, dedicated_ip.country', 'JOIN dedicated_ip ON dedicated_ip.user_id = users.user_id');

// echo '<pre>';
// print_r($getUsers);
// echo '</pre>';
// exit;
?>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row g-3">
            <div class="col-auto flex-grow-1">
                <h3 class="mb-0">All Dedicated Users</h3>

            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%; vertical-align:middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Last Login</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($getUsers)) {
                                $i = 1;
                                if (isset($getUsers[0])) {
                                    foreach ($getUsers as $user) {
                            ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $user['username'] ?></td>
                                            <td><?php echo $user['email'] ?></td>
                                            <td><?php echo $user['city'] ?></td>
                                            <td><?php echo $user['country'] ?></td>
                                            <td>
                                                <?php
                                                if ($user['last_login'] != '') {
                                                    echo date('d-m-Y h:i a', strtotime($user['last_login']));
                                                } else {
                                                    echo 'Never';
                                                }
                                                ?>
                                            </td>
                                            <td class="d-flex gap-1">
                                                <a href="backend/auth/user-management.php?action=deleteuser&user_id=<?php echo $user['user_id'] ?>">
                                                    <button type="button" class="btn btn-dark raised d-flex gap-2"><i class="material-icons-outlined">delete</i></button>
                                                </a>
                                                <a href="add-dedicated-server.php?user_id=<?php echo $user['user_id'] ?>">
                                                    <button type="button" class="btn btn-success raised d-flex gap-2"><i class="material-icons-outlined">add</i></button>
                                                </a>
                                                <a href="all-dedicated-servers.php?user_id=<?php echo $user['user_id'] ?>">
                                                    <button type="button" class="btn btn-info raised d-flex gap-2"><i class="material-icons-outlined">dns</i></button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } else {
                                    $user = $getUsers;
                                    ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $user['username'] ?></td>
                                        <td><?php echo $user['email'] ?></td>
                                        <td><?php echo $user['city'] ?></td>
                                        <td><?php echo $user['country'] ?></td>
                                        <td>
                                            <?php
                                            if ($user['last_login'] != '') {
                                                echo date('d-m-Y h:i a', strtotime($user['last_login']));
                                            } else {
                                                echo 'Never';
                                            }
                                            ?>
                                        </td>
                                        <td class="d-flex gap-1">
                                            <a href="backend/auth/user-management.php?action=deleteuser&user_id=<?php echo $user['user_id'] ?>">
                                                <button type="button" class="btn btn-dark raised d-flex gap-2"><i class="material-icons-outlined">delete</i></button>
                                            </a>
                                            <a href="add-dedicated-server.php?user_id=<?php echo $user['user_id'] ?>">
                                                <button type="button" class="btn btn-success raised d-flex gap-2"><i class="material-icons-outlined">add</i></button>
                                            </a>
                                            <a href="all-dedicated-servers.php?user_id=<?php echo $user['user_id'] ?>">
                                                <button type="button" class="btn btn-info raised d-flex gap-2"><i class="material-icons-outlined">dns</i></button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center">No User Found</td>
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
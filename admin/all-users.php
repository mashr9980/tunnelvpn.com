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
$getUsers = $crud->select('users', 'users.*, purchases.status as user_status','JOIN purchases ON purchases.user_id = users.user_id');
// print_r($getUsers);
?>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <!-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Components</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Starter Page</li>
                    </ol>
                </nav>
            </div>
        </div> -->
        <!--end breadcrumb-->
        <div class="row g-3">
            <div class="col-auto flex-grow-1">
                <h3 class="mb-0">All Premium Users</h3>
                 
            </div>
            <div class="col-auto">
                <!-- <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <a href="add-user.php">
                        <button class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>Add User</button>
                    </a>
                </div> -->
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
                                <th>Last Login</th>
                                <th>Premium Status</th>
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
                                            <td>
                                                <?php
                                                if ($user['last_login'] != '') {
                                                    echo date('d-m-Y h:i a', strtotime($user['last_login']));
                                                } else {
                                                    echo 'Never';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $user['user_status'] ?></td>
                                            <td class="d-flex gap-1">
                                                <a href="backend/auth/user-management.php?action=deleteuser&user_id=<?php echo $user['user_id'] ?>">
                                                    <button type="button" class="btn btn-dark raised d-flex gap-2"><i class="material-icons-outlined">delete</i></button>
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
                                        <td>
                                            <?php
                                            if ($user['last_login'] != '') {
                                                echo date('d-m-Y h:i a', strtotime($user['last_login']));
                                            } else {
                                                echo 'Never';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $user['user_status'] ?></td>
                                        <td class="d-flex gap-1">
                                            <a href="backend/auth/user-management.php?action=deleteuser&user_id=<?php echo $user['user_id'] ?>">
                                                <button type="button" class="btn btn-dark raised d-flex gap-2"><i class="material-icons-outlined">delete</i></button>
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
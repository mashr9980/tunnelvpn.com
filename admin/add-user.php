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
                        <h5 class="mb-4">Add New User</h5>
                        <form class="row g-3" method="post" action="backend/auth/user-management.php">
                            <div class="col-md-12">
                                <label for="input13" class="form-label">Userame</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="input13" value="<?= htmlspecialchars(old('username')) ?>" name="username" placeholder="Userame">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="input16" class="form-label">Email</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="input16" value="<?= htmlspecialchars(old('email')) ?>" name="email" placeholder="Email">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">email</i></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="input17" class="form-label">Password</label>
                                <div class="position-relative input-icon">
                                    <input type="password" class="form-control" id="input17" name="password" placeholder="Password">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">lock_open</i></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" name="createuser" class="btn btn-primary px-4">Create</button>
                                    <button type="button" class="btn btn-light px-4">Reset</button>
                                </div>
                            </div>
                            <p class="mb-0">You can login with Username and email both</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--end main wrapper-->

<?php
unset($_SESSION['old']);
include_once 'include/footer.php';
?>
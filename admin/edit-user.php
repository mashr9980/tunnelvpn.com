<?php
session_start();
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] != true) {
    header("Location: login.php");
}
if (!isset($_SESSION['login_role']) && $_SESSION['login_role'] == 'admin') {
    header("Location: login.php");
}
if (!isset($_GET['user_id'])) {
    header("Location: all-users.php");
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

$user_id = $_GET['user_id'];
$getUser = $crud->select('users', '*', null, "`user_id`=?", array($user_id));
if (is_array($getUser)) {
?>
<style>
    .pass_input{display: none;}
</style>
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
                                        <input type="hidden" class="form-control" value="<?php echo $getUser['user_id'] ?>" name="user_id">
                                        <input type="text" class="form-control" id="input13" value="<?php echo $getUser['username'] ?>" name="username" placeholder="Userame">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="input16" class="form-label">Email</label>
                                    <div class="position-relative input-icon">
                                        <input type="text" class="form-control" id="input16" value="<?php echo $getUser['email'] ?>" name="email" placeholder="Email">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">email</i></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-switch form-check-info">
                                        <input class="form-check-input" id="changepass" type="checkbox" name="pass_status" role="switch" id="flexSwitchCheckInfo">
                                        <label class="form-check-label" for="flexSwitchCheckInfo">Change Password</label>
                                    </div>
                                </div>
                                <div class="col-md-12 pass_input">
                                    <label for="input17" class="form-label">Password</label>
                                    <div class="position-relative input-icon">
                                        <input type="password" class="form-control" id="pass_1" placeholder="Password">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">lock_open</i></span>
                                    </div>
                                </div>
                                <div class="col-md-12 pass_input">
                                    <label for="input17" class="form-label">Confirm Password</label>
                                    <div class="position-relative input-icon">
                                        <input type="password" class="form-control" id="pass_2" placeholder="Confirm Password">
                                        <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">lock_open</i></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" name="updateuser" class="btn btn-primary px-4">Update</button>
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
                            <h5 class="mb-4">No User found</h5>
                            <a href="all-users.php">Go Back</a>
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
<script>
    $(document).ready(function(){
        // $('.pass_input').hide();
        $('#changepass').change(function(){
            if($(this).is(':checked')){
                $('.pass_input').show();
                $('#pass_1').attr('name','new_password');
                $('#pass_2').attr('name','confirm_password');
            }else{
                $('.pass_input').hide();
            }
        })
    })
</script>
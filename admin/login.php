<?php
session_start();

if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == true) {
  header("Location: index.php");
}

if (isset($_COOKIE['remember_token'])) {
  $token = $_COOKIE['remember_token'];
  $user = $crud->select('users', 'user_id', null, "`remember_token`=?", array($token));
  if (is_array($user)) {
    $_SESSION['login_status'] = true;
    $_SESSION['user_id'] = $user['user_id'];
    header("Location: index.php");
  } else {
    setcookie('remember_token', '', time() - 3600, "/");
  }
}

include_once 'backend/controller/config.php';
include_once 'include/head.php';
function old($key)
{
  return isset($_SESSION['oldData'][$key]) ? htmlspecialchars($_SESSION['oldData'][$key]) : '';
}
?>



<body>
  <?php
  if (isset($_SESSION['status']) == true) {
    echo '
        <script>
    Swal.fire({
        text: "' . $_SESSION['message'] . '",
        icon: "' . $_SESSION['icon'] . '"
      });
      </script>
    ';
    unset($_SESSION['message']);
    unset($_SESSION['icon']);
    unset($_SESSION['status']);
  }
  ?>
  <!--authentication-->

  <div class="mx-3 mx-lg-0">

    <div class="card my-5 col-xl-9 col-xxl-8 mx-auto rounded-4 overflow-hidden p-4">
      <div class="row g-4">
        <div class="col-lg-6 d-flex">
          <div class="card-body">
            <img src="assets/images/logo.png" class="mb-4" width="145" alt="">
            <h4 class="fw-bold">Get Started Now</h4>
            <p class="mb-3">Enter your credentials to login into Admin Panel</p>

            <div class="separator">
              <div class="line"></div>
              <p class="mb-0 fw-bold">OR</p>
              <div class="line"></div>
            </div>
            <div class="form-body mt-4">
              <form class="row g-3" method="post" action="backend/auth/user-management.php">
                <div class="col-12">
                  <label for="inputEmailAddress" class="form-label">Email / Username</label>
                  <input type="text" class="form-control" id="inputEmailAddress" value="<?= old('username') ?>" name="username" placeholder="jhon@example.com">
                </div>
                <div class="col-12">
                  <label for="inputChoosePassword" class="form-label">Password</label>
                  <div class="input-group" id="show_hide_password">
                    <input type="password" class="form-control border-end-0" name="password" value="<?= old('password') ?>" id="inputChoosePassword" placeholder="Enter Password">
                    <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <input class="form-check-input" name="remember_me" type="checkbox" id="flexSwitchCheckChecked">
                    <label class="form-check-label" <?= old('remember_me') ? 'checked' : '' ?> for="flexSwitchCheckChecked">Remember Me</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button type="submit" name="loginuser" class="btn btn-primary">Login</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-6 d-lg-flex d-none">
          <div class="p-3 rounded-4 w-100 d-flex align-items-center justify-content-center bg-light">
            <img src="assets/images/auth/login1.png" class="img-fluid" alt="">
          </div>
        </div>

      </div><!--end row-->
    </div>

  </div>




  <!--authentication-->


  <?php
  unset($_SESSION['oldData']);
  ?>


  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("bi-eye-slash-fill");
          $('#show_hide_password i').removeClass("bi-eye-fill");
        } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("bi-eye-slash-fill");
          $('#show_hide_password i').addClass("bi-eye-fill");
        }
      });
    });
  </script>

</body>

</html>
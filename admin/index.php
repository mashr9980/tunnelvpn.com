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
$getServers = $crud->select('servers', '*');
$getServers = is_array($getServers) ? $getServers : array();
$numberOfServers = count($getServers);

$getSubServers = $crud->select('sub_servers', 'sub_servers.*, servers.server_name as server_name, servers.status as status', 'JOIN servers ON sub_servers.server_id = servers.server_id');
$getSubServers = is_array($getSubServers) ? $getSubServers : array();
$numberOfSubServers = count($getSubServers);

$getPremium = $crud->select('users', '*', 'JOIN purchases ON purchases.user_id = users.user_id');
$numberOfPremiumUsers = is_array($getPremium) && isset($getPremium[0]) ? count($getPremium) : 1;

$freeUsers = $crud->select(
  'users',
  'u.*',
  'LEFT JOIN purchases p ON u.user_id = p.user_id',
  'p.user_id IS NULL',
  array(),
  null,
  null,
  'u'
);
$getUser = is_array($freeUsers) ? $freeUsers : array();
$numberOfUsers = count($getUser);
?>
<!--start main wrapper-->
<main class="main-wrapper">
  <div class="main-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Dashboard</div>
      <div class="ps-3">
      </div>
    </div>
    <!--end breadcrumb-->


    <div class="row">
      <div class="col-12 col-xl-8 d-flex">
        <div class="card rounded-4 w-100">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-around flex-wrap gap-4 p-4">
              <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                <a href="javascript:;" class="mb-2 wh-48 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                  <i class="material-icons-outlined">widgets</i>
                </a>
                <h3 class="mb-0"><?php echo $numberOfPremiumUsers ?></h3>
                <p class="mb-0">Premium Users</p>
              </div>
              <div class="vr"></div>
              <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                <a href="javascript:;" class="mb-2 wh-48 bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center">
                  <i class="material-icons-outlined">dns</i>
                </a>
                <h3 class="mb-0"><?php echo $numberOfServers ?></h3>
                <p class="mb-0">Servers</p>
              </div>
              <div class="vr"></div>
              <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                <a href="javascript:;" class="mb-2 wh-48 bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center">
                  <i class="material-icons-outlined">dns</i>
                </a>
                <h3 class="mb-0"><?php echo $numberOfSubServers ?></h3>
                <p class="mb-0">Sub Servers</p>
              </div>
              <div class="vr"></div>

              <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                <a href="javascript:;" class="mb-2 wh-48 bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center">
                  <i class="material-icons-outlined">manage_accounts</i>
                </a>
                <h3 class="mb-0"><?php echo $numberOfUsers ?></h3>
                <p class="mb-0">Free Users</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-xl-12 d-flex">
        <div class="card rounded-4 w-100">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-3">
              <div class="">
                <h4 class="mb-0"><?php echo $numberOfUsers ?></h4>
                <p class="mb-0">Free Users</p>
              </div>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" style="width:100%; vertical-align:middle">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Last Login</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (is_array($freeUsers)) {
                    $i = 1;
                    if (isset($freeUsers[0])) {
                      foreach ($freeUsers as $user) {
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
                          <td class="d-flex gap-1">
                            <a href="" data-id="<?php echo $user['user_id'] ?>" class="deleteuser">
                              <button type="button" class="btn btn-dark raised d-flex gap-2"><i class="material-icons-outlined">delete</i></button>
                            </a>
                          </td>
                        </tr>
                      <?php
                        $i++;
                      }
                    } else {
                      $user = $freeUsers;
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
                        <td class="d-flex gap-1">
                          <a href="javascript;" data-id="<?php echo $user['user_id'] ?>" class="deleteuser">
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
    </div>
  </div>
</main>
<!--end main wrapper-->

<?php
include_once 'include/footer.php';
?>
<script>
  $(document).ready(function() {

    $(".deleteuser").on('click', function(e) {
      e.preventDefault();
      var userId = $(this).data('id');

      $.ajax({
        url: 'backend/api/user-auth-api.php?action=deleteuser', // Adjust this URL to your API endpoint
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
          user_id: userId
        }),
        success: function(response) {
          // console.log(response);
          if (response.status === true) {
            showMessage('success', response.message);
            setTimeout(function() {
              location.reload();
            }, 2000);
          } else {
            showMessage('error', response.message);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          showMessage('info', textStatus);
        }
      });
    });

    function showMessage(type, msg) {
      Swal.fire({
        text: msg,
        icon: type
      });
    }


    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    $.ajax({
      url: 'backend/controller/save-timezone.php',
      type: 'POST',
      data: {
        timezone: timezone,
        action: 'savetime'
      },
      success: function(response) {
        if (response != true) {
          console.log('Failed to save timezone');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    })
  })
</script>
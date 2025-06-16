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
$getPromo = $crud->select('promo_codes', '*');
?>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row g-3">

            <div class="col-auto flex-grow-1">
                <h3 class="mb-0">All Promo Codes</h3>
            </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <a href="add-promo-code.php">
                        <button class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>Add Promo Code</button>
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
                                <th>Code</th>
                                <th>Expiration Date</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($getPromo)) {
                                $i = 1;
                                if (isset($getPromo[0])) {
                                    foreach ($getPromo as $promo) {
                            ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $promo['code'] ?></td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($promo['expiration_date'])); ?></td>
                                            <td>
                                                <?php
                                                $status = (new DateTime($promo['expiration_date']) >= new DateTime()) ? 'Active' : 'Expired';
                                                $buttonClass = ($status == 'Active') ? 'btn-inverse-success' : 'btn-inverse-danger';
                                                ?>
                                                <div style="cursor: default;" class="btn <?= $buttonClass ?>"><?= $status ?></div>
                                            </td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($promo['created_at'])); ?></td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($promo['updated_at'])); ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="edit-promo-code.php?promo_id=<?php echo $promo['promo_id'] ?>">
                                                        <button type="button" class="btn btn-info raised d-flex gap-2"><i class="material-icons-outlined">edit</i></button>
                                                    </a>
                                                    <a href="backend/manager/promo-manage.php?action=deletepromo&promo_id=<?php echo $promo['promo_id'] ?>">
                                                        <button type="button" class="btn btn-dark raised d-flex gap-2"><i class="material-icons-outlined">delete</i></button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } else {
                                    $promo = $getPromo;
                                    ?>
                                    <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $promo['code'] ?></td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($promo['expiration_date'])); ?></td>
                                            <td>
                                                <?php
                                                $status = (new DateTime($promo['expiration_date']) >= new DateTime()) ? 'Active' : 'Expired';
                                                $buttonClass = ($status == 'Active') ? 'btn-inverse-success' : 'btn-inverse-danger';
                                                ?>
                                                <div style="cursor: default;" class="btn <?= $buttonClass ?>"><?= $status ?></div>
                                            </td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($promo['created_at'])); ?></td>
                                            <td><?php echo date('d-m-Y h:i a', strtotime($promo['updated_at'])); ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="edit-promo-code.php?promo_id=<?php echo $promo['promo_id'] ?>">
                                                        <button type="button" class="btn btn-info raised d-flex gap-2"><i class="material-icons-outlined">edit</i></button>
                                                    </a>
                                                    <a href="backend/manager/promo-manage.php?action=deletepromo&promo_id=<?php echo $promo['promo_id'] ?>">
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
                                    <td colspan="7" class="text-center">No Promo Code Found</td>
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
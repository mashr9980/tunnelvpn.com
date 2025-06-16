<!--start overlay-->
<div class="overlay btn-toggle"></div>
<!--end overlay-->
<!--start switcher-->
<button class="btn btn-primary position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
  <i class="material-icons-outlined">tune</i>Customize
</button>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
  <div class="offcanvas-header border-bottom h-70">
    <div class="">
      <h5 class="mb-0">Theme Customizer</h5>
      <p class="mb-0">Customize your theme</p>
    </div>
    <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
      <i class="material-icons-outlined">close</i>
    </a>
  </div>
  <div class="offcanvas-body">
    <div>
      <p>Theme variation</p>

      <div class="row g-3">
        <div class="col-12 col-xl-6">
          <input type="radio" class="btn-check" name="theme-options" id="LightTheme" checked>
          <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="LightTheme">
            <span class="material-icons-outlined">light_mode</span>
            <span>Light</span>
          </label>
        </div>
        <div class="col-12 col-xl-6">
          <input type="radio" class="btn-check" name="theme-options" id="DarkTheme">
          <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="DarkTheme">
            <span class="material-icons-outlined">dark_mode</span>
            <span>Dark</span>
          </label>
        </div>
        <div class="col-12 col-xl-6">
          <input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme">
          <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="SemiDarkTheme">
            <span class="material-icons-outlined">contrast</span>
            <span>Semi Dark</span>
          </label>
        </div>
        <div class="col-12 col-xl-6">
          <input type="radio" class="btn-check" name="theme-options" id="BoderedTheme">
          <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="BoderedTheme">
            <span class="material-icons-outlined">border_style</span>
            <span>Bordered</span>
          </label>
        </div>
      </div><!--end row-->

    </div>
  </div>
</div>
<!--start switcher-->


<!--bootstrap js-->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<!--plugins-->
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="assets/plugins/metismenu/metisMenu.min.js"></script>
<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/js/flatpickr.js"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });

  $(".date-time").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
  });
</script>
<script>
  $(document).ready(function() {
    var table = $('#example2').DataTable({
      lengthChange: false,
      buttons: ['copy', 'excel', 'pdf', 'print']
    });

    table.buttons().container()
      .appendTo('#example2_wrapper .col-md-6:eq(0)');
  });
</script>
<script src="assets/js/index.js"></script>
<script src="assets/plugins/peity/jquery.peity.min.js"></script>
<script>
  $(".data-attributes span").peity("donut")
</script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/js/main.js"></script>


</body>

</html>
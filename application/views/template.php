<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Web Monitoring</title>

  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>public/assets/images/favicon.png">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url() ?>public/assets/datatables/datatables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>public/assets/plugins/fancytree/dist/skin-win8/ui.fancytree.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>public/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>public/assets/plugins/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>public/assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>public/assets/css/components.css">

  <style>
    .title {
      font-size: 16px;
      line-height: 28px;
      color: #6777ef;
      padding-right: 10px;
      margin-bottom: 0;
    }
    input[type=checkbox] {
      width: 12px;
      height: 12px;
    }
    .form-group {
      margin-bottom: 0.5rem !important;
    }
    .form-control--small {
      height: calc(1.5em + .5rem + 2px) !important;
    }
    audio {
      max-width: 100%;
    }
    thead th {
      white-space: nowrap;
    }
    .costum-table {
      width: 100%;
      color: #000;
      font-size: 10px;
    }
    .fancytree-title {
      font-size: 12px !important;
    }
    .select2-container .select2-search--inline .select2-search__field {
      margin-top: 8.5px;
      margin-left: 0;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice, .select2-container--default .select2-results__option[aria-selected=true], .select2-container--default .select2-results__option--highlighted[aria-selected] {
      margin-top: 8.5px;
    }
    .custom-select.custom-select-sm.form-control.form-control-sm {
      height: calc(1.5em + .5rem + 2px) !important;
      padding: 0 !important;
      padding-left: 10px !important;
      padding-right: 25px !important;
    }
    .section .section-header h1 {
      font-size: 14px;
    }
    .date-label {
      font-size: 10px;
    }
    .datepicker .datepicker-switch, .datepicker td, .datepicker th, .form-check-label {
      font-size: 12px !important;
    }
    .item-edit {
      color: #47c363;
    }
    .item-edit--margin {
      margin-right: 10px;
    }
    .item-edit-password {
      color: #6777ef;
    }
    .item-edit-password--margin {
      margin-right: 10px;
    }
    .item-delete {
      color: #fc544b;
    }
    .item-delete--margin {
      margin-right: 10px;
    }
    .tapid {
      font-size: 14px;
      padding: 10px 15px;
      height: 42px;
      color: "white";
      background-color: #eee;
    }
    .tapid:hover {
      color: white;
      background-color: #7f63f4;
    }
  </style>
</head>

<body class="sidebar-mini">
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?= base_url() ?>public/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block"><?= $this->session->userdata('username') ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="#" class="dropdown-item has-icon" id="password-modal">
                <i class="fas fa-cog"></i> Password
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url() ?>login/logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#">WEBMON</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">WM</a>
          </div>
          <ul class="sidebar-menu">
            <?php
              $queryMenu = "select tbl_user.id as id_user, tbl_menu.* from tbl_user
                            join tbl_role_user on tbl_user.id = tbl_role_user.id_user
                            join tbl_role_menu on tbl_role_user.id_role = tbl_role_menu.id_role
                            join tbl_menu on tbl_role_menu.id_menu = tbl_menu.id
                            where tbl_user.id = " . $this->session->userdata('id') . "
                            order by tbl_menu.urutan";
              $data_menu = $this->db->query($queryMenu)->result_array();
              foreach ($data_menu as $menu) :
            ?>
              <li><a class="nav-link" href="<?= base_url($menu["url"]) ?>"><i class="<?= $menu["icon"] ?>"></i> <span><?= $menu["label"] ?></span></a></li>
            <?php endforeach; ?>
          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $page; ?></h1>
          </div>

          <div class="section-body">
            <?= $contents; ?>
          </div>
        </section>
      </div>
      <?php if (isset($modals)) : ?>
        <?php foreach ($modals as $row) : ?>
          <?php $row; ?>
        <?php endforeach; ?>
      <?php endif; ?>
      <?php $this->load->view('auth/password'); ?>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; ATLAS
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
  <script src="<?= base_url() ?>public/assets/plugins/fancytree/dist/jquery.fancytree-all-deps.min.js"></script>
  <script src="<?= base_url() ?>public/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="<?= base_url() ?>public/assets/plugins/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
  <script src="<?= base_url() ?>public/assets/plugins/moment/moment.min.js"></script>
  <script src="<?= base_url() ?>public/assets/js/kweb/helpers.js"></script>
  <script src="<?= base_url() ?>public/assets/js/kweb/auth/modal.js"></script>
  <script src="<?= base_url() ?>public/assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="<?= base_url() ?>public/assets/datatables/datatables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Template JS File -->
  <script src="<?= base_url() ?>public/assets/js/scripts.js"></script>
  <script src="<?= base_url() ?>public/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script>
    $(".select2").select2({
      dropdownAutoWidth: true
    });
    $(".datepicker").datepicker({
      autoclose: true,
      language: "id",
      format: "dd-mm-yyyy"
    });
  </script>
  <?php if (isset($js)) : ?>
    <script>
      var base_url = "<?= base_url() ?>";
      var api_play = "<?= $this->config->item('api_play') ?>";
      var api_mc = "<?= $this->config->item('api_mc') ?>";
      var id = "<?= $this->session->userdata('id'); ?>"
      var auth = "<?= $this->session->userdata('status'); ?>";
    </script>
    <?php foreach ($js as $row) : ?>
      <script src="<?= base_url() ?><?= $row; ?>"></script>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>

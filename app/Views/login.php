<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Pendaftaran Kongres</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url('templates/backend/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('templates/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('templates/backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">

  <link rel="stylesheet" href="<?= base_url('templates/backend/dist/css/adminlte.min.css') ?>">
  <script>
    var BASE_URL = '<?= base_url() ?>/';
  </script>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img src="<?= base_url('templates/backend/cropped-Logo-untuk-web-1.png') ?>" alt="">
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Login Page</p>

        <form method="post" id="fSignIn">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="button" class="btn btn-primary btn-block" id="btnSignIn">Sign in</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <script src="<?= base_url('templates/backend/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('templates/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('templates/backend/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

  <script src="<?= base_url('templates/backend/dist/js/adminlte.min.js') ?>"></script>
  <script src="<?= base_url('login.js?' . time()) ?>"></script>

</body>

</html>
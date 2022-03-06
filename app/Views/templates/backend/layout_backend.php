<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Pendaftaran KOGI</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?= base_url('templates/backend/plugins/fontawesome-free/css/all.min.css') ?>">

    <link rel="stylesheet" href="<?= base_url('templates/backend/dist/css/adminlte.min.css?v=3.2.0') ?>">

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav"></ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>


        <?= $this->include('templates/backend/sidebar') ?>

        <?= $this->renderSection('content') ?>

        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>

            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>



    <script src="<?= base_url('templates/backend/plugins/jquery/jquery.min.js') ?>"></script>

    <script src="<?= base_url('templates/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <script src="<?= base_url('templates/backend/dist/js/adminlte.min.js?v=3.2.0') ?>"></script>
</body>

</html>
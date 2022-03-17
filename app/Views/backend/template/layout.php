<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Pendaftaran KOGI</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?= base_url('templates/backend/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('templates/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('templates/backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">

    <link rel="stylesheet" href="<?= base_url('templates/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('templates/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('templates/backend/dist/css/adminlte.min.css?v=3.2.0') ?>">
    <?= $this->renderSection('css') ?>

    <script>
        var BASE_URL = '<?= base_url() ?>/';
    </script>


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>


        <?= $this->include('backend/template/sidebar') ?>

        <?= $this->renderSection('content') ?>

        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>

            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>

    <div class="modal fade" id="modal-ajax">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer justify-content-between">
                    <button bModalClose type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button bModalDone type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <template id="loading-spin">
        <div class="card" style="box-shadow: none;">
            <div class="card-body">
                <div class="overlay">
                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
            </div>

        </div>
    </template>

    <script src="<?= base_url('templates/backend/plugins/jquery/jquery.min.js') ?>"></script>

    <script src="<?= base_url('templates/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('templates/backend/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('templates/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('templates/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
    <script src="<?= base_url('templates/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('templates/backend/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

    <script src="<?= base_url('templates/backend/dist/js/adminlte.min.js?v=3.2.0') ?>"></script>
    <script src="<?= base_url('templates/backend/backend.js?' . time()) ?>"></script>

    <?= $this->renderSection('js') ?>

</body>

</html>
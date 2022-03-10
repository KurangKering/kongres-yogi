<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Pendaftaran</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="<?= base_url('templates/frontend/assets/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('templates/frontend/assets/css/material-kit.css?v=1.2.1') ?>" rel="stylesheet" />
    <link href="<?= base_url('templates/frontend/assets/css/custom.css') ?>" rel="stylesheet" />
    <script>
        var BASEURL = '<?= base_url() ?>/';
    </script>
</head>

<body class="signup-page">
    <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">KOGI</a>
            </div>

            <?= $this->include('templates/frontend/sidebar') ?>
        </div>
    </nav>


    <?= $this->renderSection('content') ?>



    <div class="modal fade" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-notice ">
            <div class="modal-content alert alert-danger">

                <div class="modal-body" id="modalBody">

                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="<?= base_url('templates/frontend/assets/js/jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('templates/frontend/assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('templates/frontend/assets/js/material.min.js') ?>"></script>

<!--    Plugin for Date Time Picker and Full Calendar Plugin   -->
<script src="<?= base_url('templates/frontend/assets/js/moment.min.js') ?>"></script>

<!--	Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/   -->
<script src="<?= base_url('templates/frontend/assets/js/nouislider.min.js') ?>" type="text/javascript"></script>

<!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker   -->
<script src="<?= base_url('templates/frontend/assets/js/bootstrap-datetimepicker.js') ?>" type="text/javascript"></script>

<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select   -->
<script src="<?= base_url('templates/frontend/assets/js/bootstrap-selectpicker.js') ?>" type="text/javascript"></script>

<!--	Plugin for Tags, full documentation here: http://xoxco.com/projects/code/tagsinput/   -->
<script src="<?= base_url('templates/frontend/assets/js/bootstrap-tagsinput.js') ?>"></script>

<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput   -->
<script src="<?= base_url('templates/frontend/assets/js/jasny-bootstrap.min.js') ?>"></script>

<!--    Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc    -->
<script src="<?= base_url('templates/frontend/assets/js/material-kit.js?v=1.2.1') ?>" type="text/javascript"></script>
<script src="<?= base_url('templates/frontend/assets/js/custom.js') ?>" type="text/javascript"></script>

</html>
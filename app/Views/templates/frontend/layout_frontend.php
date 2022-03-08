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

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#">
                            <i class="material-icons">apps</i> Pendaftaran
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="material-icons">apps</i> Validasi Pembayaran
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="page-header header-filter" filter-color="purple">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <div class="card card-signup">
                        <h2 class="card-title text-center">PENDAFTARAN</h2>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <form class="form" method="" action="">
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="Nama">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="Email...">
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <a href="#pablo" class="btn btn-primary btn-round">Daftar Sekarang</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

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

<!--    Plugin For Google Maps   -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

<!--    Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc    -->
<script src="<?= base_url('templates/frontend/assets/js/material-kit.js?v=1.2.1') ?>" type="text/javascript"></script>

</html>
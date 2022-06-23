<?= $this->extend('frontend/template/layout') ?>
<?= $this->section('content') ?>
<div class="page-header header-filter" filter-color="purple">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="card card-signup">
                    <h2 class="card-title text-center">Periksa Data Pendaftaran</h2>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">

                            <form class="form" method="" action="">
                                <div class="card-content">
                                    <div id="form-message">
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label">No. Pendaftaran</label>
                                        <input type="text" class="form-control" name="id_pendaftaran">
                                    </div>
                                </div>
                                <div class="footer text-center">
                                    <a href="javascript:void(0)" id="btnPeriksaDataPendaftaran" class="btn btn-primary btn-round">CEK</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
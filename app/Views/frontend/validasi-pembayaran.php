<?= $this->extend('templates/frontend/layout_frontend') ?>
<?= $this->section('content') ?>
<div class="page-header header-filter" filter-color="purple">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="card card-signup">
                    <h2 class="card-title text-center">Validasi Pembayaran</h2>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div id="form-message">

                            </div>
                            <form class="form" method="" action="">
                                <div class="card-content">

                                    <div class="form-group label-floating">
                                        <label class="control-label">No. Pendaftaran</label>
                                        <input type="text" class="form-control" name="id_pendaftaran">
                                    </div>

                                    <div class="form-group form-file-upload">
                                        <input type="file" name="file" id="inputFile2" multiple="">
                                        <div class="input-group">
                                            <input type="text" readonly="" class="form-control" placeholder="Single File">
                                            <span class="input-group-btn input-group-s">
                                                <button type="button" class="btn btn-just-icon btn-round btn-primary">
                                                    <i class="material-icons">attach_file</i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer text-center">
                                    <a href="javascript:void(0)" id="btnSubmitValidasiPembayaran" class="btn btn-primary btn-round">SUBMIT</a>
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
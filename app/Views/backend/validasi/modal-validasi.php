<div class="card">
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-info"></i> Pemberitahuan!</h5>
        Pesan Pemberitahuan bukti pembayaran diterima atau ditolak akan dikirim ke email pendaftar.
    </div>
    <form class="form-horizontal" id="fValidasi" action="<?= base_url() . '/backend/validasi/validasi' ?>" method="POST">
        <div class="card-body">

            <input type="hidden" name="id" value="<?= $data['id_validasi'] ?>">
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">No Pendaftaran</label>
                <div class="col-sm-9">
                    <input type="text" id="email" class="form-control" disabled value="<?= $data['id_pendaftaran'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Nama Peserta</label>
                <div class="col-sm-9">
                    <input type="text" id="email" class="form-control" disabled value="<?= $data['nama'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" id="email" class="form-control" disabled value="<?= $data['email'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label">Keputusan</label>
                <div class="col-sm-9">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="status-terima" name="status" value="sukses">
                        <label for="status-terima" required class="custom-control-label">Terima Bukti Pembayaran</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input custom-control-input-danger" type="radio" id="status-tolak" name="status" value="gagal">
                        <label for="status-tolak" class="custom-control-label">Tolak Bukti Pembayaran</label>
                    </div>
                </div>
            </div>
            <div id="content-alasan-penolakan" style="display: none;">
                <div class="form-group row">
                    <label for="alasan-penolakan" class="col-sm-3 col-form-label">Alasan Penolakan</label>
                    <div class="col-sm-9">
                        <textarea name="alasan-penolakan" class="form-control" id="summernote"><ul><li>Gambar tidak jelas</li></ul></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer -->
    </form>
</div>

<script>
    $('#summernote').summernote('destroy');
    $('#summernote').summernote();
</script>
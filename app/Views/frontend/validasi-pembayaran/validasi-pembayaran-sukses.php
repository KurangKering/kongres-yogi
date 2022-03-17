<?= $this->extend('frontend/template/layout') ?>
<?= $this->section('content') ?>
<div class="page-header header-filter" filter-color="purple">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="icon icon-success">
                                <i class="material-icons" style="font-size: 4.4em">verified_user</i>
                            </div>
                            <h4 class="info-title">Berhasil submit bukti pembayaran</h4>
                            <?php $email = $data['pendaftaran']['email']; ?>
                            <p>Bukti pembayaran dengan <b>No Pendaftaran <?= $data['pendaftaran']['id'] ?></b> atas nama <b><?= $data['pendaftaran']['nama'] ?></b> berhasil disubmit. Hasil verifikasi bukti pembayaran akan diumumkan melalui email. Silahkan cek email secara berkala. </p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</div>
<?= $this->endSection() ?>
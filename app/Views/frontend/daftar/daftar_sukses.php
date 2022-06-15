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
                                <i class="material-icons" style="font-size: 4.4em">verified</i>
                            </div>
                            <h4 class="info-title">Pendaftaran Berhasil</h4>
                            <?php $email = $data['pendaftaran']['email']; ?>
                            <p>Kami telah mengirim detail pendaftaran ke email <b><?= $email ?></b> . Silahkan cek email anda. </p></br>
                            <p>Jika tidak menerima e-mail, silahkan hubungi WA(0813 7439 1461)</p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</div>
<?= $this->endSection() ?>

<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Validasi Pembayaran</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table-data-validasi" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl. Validasi</th>
                                        <th>Nama</th>
                                        <th>Kontak</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $(document).on("click", "[bDetail]", function(e) {
            let id = $(this).attr("bDetail");
            openModal({
                classDialog: 'modal-lg',
                title: "Detail Submit Validasi Pembayaran",
                src: BASE_URL + "backend/validasi/detail/" + id,
                buttonClose: {
                    title: "Tutup",
                    action: function() {},
                },
                buttonDone: false,
            });
        });

        $(document).on("click", "[bVerifikasiii]", function(e) {
            let id = $(this).attr("bDetail");
            openModal({
                classDialog: 'modal-lg',
                title: "Verifikasi Pembayaran",
                src: BASE_URL + "backend/validasi/render-verifikasi/" + id,
                buttonClose: {
                    title: "Tutup",
                    action: function() {},
                },
                buttonDone: false,
            });
        });
    });
</script>
<?php $this->endSection() ?>
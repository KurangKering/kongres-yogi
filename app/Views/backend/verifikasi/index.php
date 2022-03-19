<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Sudah Verifikasi</h1>
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
                            <div class="table-responsive">
                                <table id="table-data-verifikasi" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl. Verifikasi</th>
                                            <th>Nama</th>
                                            <th>Kontak</th>
                                            <th>Total</th>
                                            <th>Bukti Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
        var processingVerifikasi = false;


        let table_data_verifikasi = $("#table-data-verifikasi").DataTable({
            processing: true,
            serverSide: true,
            "order": [],
            ordering: false,
            "aaSorting": [],
            ajax: BASE_URL + "backend/verifikasi/json-verifikasi",
            columns: [{
                    data: "id_pendaftaran",
                },
                {
                    data: "tanggal_verifikasi",
                },
                {
                    data: "nama",
                },
                {
                    data: "no_hp",
                },
                {
                    data: "total",
                },
                {
                    data: "file",
                },
                {
                    data: "action",
                },
            ],
            columnDefs: [{
                targets: -1,
                width: '160px'
            }, {
                targets: -2,
                width: '100px',
                className: 'text-center',
            }, ],
        });

        $(document).on("click", "[bDetail]", function(e) {
            let id = $(this).attr("bDetail");
            openModal({
                classDialog: 'modal-lg',
                title: "Detail Data Verifikasi",
                src: BASE_URL + "backend/verifikasi/detail/" + id,
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
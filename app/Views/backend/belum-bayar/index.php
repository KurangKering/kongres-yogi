<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Pendaftaran</h1>
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
                            <table id="table-data-pendaftaran" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl. Pendaftaran</th>
                                        <th>Nama</th>
                                        <th>Kontak</th>
                                        <th>Total</th>
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
        let table_data_pendaftaran = $("#table-data-pendaftaran").DataTable({
            processing: true,
            serverSide: true,
            ajax: BASE_URL + "backend/belum-bayar/json-pendaftaran",
            columns: [{
                    data: "id",
                },
                {
                    data: "tanggal_pendaftaran",
                },
                {
                    data: "nama",
                },
                {
                    data: "no_hp",
                },
                {
                    data: "total_pembayaran",
                },
                {
                    data: "action",
                },
            ],
            columnDefs: [{
                targets: -1,
            }, ],
        });

        $(document).on("click", "[bDetailPendaftaran]", function(e) {

            let id = $(this).attr("bDetailPendaftaran");

            openModal({
                classDialog: 'modal-lg',
                title: "Detail Pendaftaran",
                src: BASE_URL + "backend/belum-bayar/detail/" + id,
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

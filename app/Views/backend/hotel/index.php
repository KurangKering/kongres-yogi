<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Hotel</h1>
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
                            <table id="table-data-hotel" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Hotel</th>
                                        <th>Jenis Kamar</th>
                                        <th>Harga</th>
                                        <th>Kuota</th>
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
        let table_data_hotel = $("#table-data-hotel").DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: BASE_URL + "backend/hotel/json-hotel",
            columns: [{
                    data: "id_hotel",
                },
                {
                    data: "nama_hotel",
                },
                {
                    data: "jenis_kamar",
                },
                {
                    data: "harga",
                },
                {
                    data: "jumlah",
                },
                {
                    data: "action",
                },
            ],
            columnDefs: [{
                targets: -1,
            }, ],
        });

        $(document).on("click", "[bCheckTanggal]", function(e) {
            let id = $(this).attr("bCheckTanggal");
            openModal({
                classDialog: 'modal-lg',
                title: "Informasi Hotel Terpakai",
                src: BASE_URL + "backend/hotel/list-terpakai/" + id,
                buttonClose: {
                    title: "Tutup",
                    action: function() {},
                },
                buttonDone: false,
            });
        });

        $(document).on("click", "[bDetailPendaftaran]", function(e) {

            let id = $(this).attr("bDetailPendaftaran");

            openModal({
                classDialog: 'modal-lg',
                title: "Detail Pendaftaran",
                src: BASE_URL + "backend/pendaftaran/detail/" + id,
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
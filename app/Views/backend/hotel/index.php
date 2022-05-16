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
            ],
            columnDefs: [{
                targets: -1,
            }, ],
        });
    });
</script>
<?php $this->endSection() ?>
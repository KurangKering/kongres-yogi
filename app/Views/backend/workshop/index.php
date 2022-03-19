<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Workshop</h1>
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
                            <table id="table-data-workshop" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Event</th>
                                        <th>Pelatihan</th>
                                        <th>Kuota</th>
                                        <th>Terpakai</th>
                                        <th>Waktu Kegiatan</th>
                                        <th>Tempat</th>
                                        <th>Biaya</th>
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
        let table_data_workshop = $("#table-data-workshop").DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: BASE_URL + "backend/workshop/json-workshop",
            columns: [{
                    data: "id_workshop",
                },
                {
                    data: "nama_event",
                },
                {
                    data: "pelatihan",
                },
                {
                    data: "kuota",
                },
                {
                    data: "terpakai",
                },
                {
                    data: "waktu",
                },
                {
                    data: "tempat",
                },
                {
                    data: "biaya",
                },
            ],
            columnDefs: [{
                targets: -1,
            }, ],
        });
    });
</script>
<?php $this->endSection() ?>
<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Event</h1>
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
                            <table id="table-data-event" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Event</th>
                                        <th>Buka Pendaftaran</th>
                                        <th>Tutup Pendaftaran</th>
                                        <th>Active</th>
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
        let table_data_event = $("#table-data-event").DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: BASE_URL + "backend/event/json-event",
            columns: [{
                    data: "id_event",
                },
                {
                    data: "nama_event",
                },
                {
                    data: "mulai_pendaftaran",
                },
                {
                    data: "selesai_pendaftaran",
                },
                {
                    data: "active",
                },
            ],
            columnDefs: [{
                targets: -1,
            }, ],
        });
    });
</script>
<?php $this->endSection() ?>
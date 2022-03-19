<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Event Simposium</h1>
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
                            <table id="table-data-event-simposium" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Event</th>
                                        <th>Kategori</th>
                                        <th>Hybrid</th>
                                        <th>Tipe Pendaftaran</th>
                                        <th>Harga</th>
                                        <th>Waktu Pendaftaran</th>
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
        let table_data_event_simposium = $("#table-data-event-simposium").DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: BASE_URL + "backend/event-simposium/json-event-simposium",
            columns: [{
                    data: "id_event_simposium",
                },
                {
                    data: "nama_event",
                },
                {
                    data: "kategori",
                },
                {
                    data: "hybrid",
                },
                {
                    data: "tipe_pendaftaran",
                },
                {
                    data: "harga",
                },
                {
                    data: "waktu_pendaftaran",
                },
                {
                    data: "action",
                },
            ],
            columnDefs: [{
                targets: -1,
            }, ],
        });

        $(document).on("click", "[bDetail]", function(e) {
            let id = $(this).attr("bDetail");

            openModal({
                classDialog: 'modal-lg',
                title: "Detail Event Simposium",
                src: BASE_URL + "backend/event-simposium/detail/" + id,
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
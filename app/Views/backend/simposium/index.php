<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Master Simposium</h1>
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
                            <table id="table-data-simposium" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Hybrid</th>
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

<?php $this->section('js') ?>
<script>
    $(document).ready(function() {


        let table_data_simposium = $("#table-data-simposium").DataTable({
            processing: true,
            serverSide: true,
            ajax: BASE_URL + "backend/simposium/json-simposium",
            columns: [{
                    data: "id_simposium",
                },
                {
                    data: "kategori",
                },
                {
                    data: "hybrid",
                },
            ],
            columnDefs: [{
                targets: -1,
            }, ],
        });
    });
</script>
<?php $this->endSection() ?>
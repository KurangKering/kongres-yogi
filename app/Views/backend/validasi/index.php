<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Sudah Bayar</h1>
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
                                <table id="table-data-validasi" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl. Validasi</th>
                                            <th>Nama</th>
                                            <th>Kontak</th>
                                            <th>Total</th>
                                            <th>file</th>
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


        let table_data_validasi = $("#table-data-validasi").DataTable({
            processing: true,
            serverSide: true,
            "order": [],
            ordering: false,
            "aaSorting": [],
            ajax: BASE_URL + "backend/validasi/json-validasi-sudah-bayar",
            columns: [{
                    data: "id_pendaftaran",
                },
                {
                    data: "tanggal_validasi",
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
                title: "Detail Data Pendaftaran",
                src: BASE_URL + "backend/validasi/detail/" + id,
                buttonClose: {
                    title: "Tutup",
                    action: function() {},
                },
                buttonDone: false,
            });
        });


        $(document).on("click", "[bVerifikasi]", function() {
            let $button = $(this);


            if ($button.attr("submit") == "false") {
                return;
            }

            if (processingVerifikasi) {
                Toast.fire({
                    icon: 'error',
                    title: 'Proses verifikasi sedang berjalan'
                })
                return;
            }

            Swal.fire({
                icon: 'question',
                title: "Apakah data ini valid?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Valid, terima data",
                denyButtonText: `Tidak, hapus data`,
            }).then((result) => {
                let status = null;
                if (result.isConfirmed || result.isDenied) {
                    if (result.isConfirmed) {
                        status = 1;
                    } else if (result.isDenied) {
                        status = 0;
                    }
                    processingVerifikasi = true;

                    let formData = new FormData();
                    formData.append("id", $button.attr("bVerifikasi"));
                    formData.append("status", status);

                    $button.attr("submit", "false");
                    $button.html('<i class="fa fa-spinner fa-spin"></i>');

                    $.ajax({
                            type: "POST",
                            url: BASE_URL + "backend/validasi/validasi",
                            data: formData,
                            cache: false,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    console.log(response);
                                    Swal.fire({
                                        icon: "success",
                                        title: "Sukses",
                                        text: response.message,
                                    });

                                    table_data_validasi.ajax.reload();
                                }
                            },
                        })
                        .always(function(e) {
                            $button.attr("submit", "true");
                            $button.html("<i class=\"fas fa-check\"></i> Verifikasi");
                            processingVerifikasi = false
                        })
                }
            });
        });
    });
</script>

<?php $this->endSection() ?>
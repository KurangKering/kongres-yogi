<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Validasi</h1>
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
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-menunggu-diverifikasi-tab" data-toggle="pill" href="#custom-tabs-menunggu-diverifikasi" role="tab" aria-controls="custom-tabs-menunggu-diverifikasi" aria-selected="true">Menunggu Verifikasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-data-diterima-tab" data-toggle="pill" href="#custom-tabs-data-diterima" role="tab" aria-controls="custom-tabs-data-diterima" aria-selected="false">Data Diterima</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-data-ditolak-tab" data-toggle="pill" href="#custom-tabs-data-ditolak" role="tab" aria-controls="custom-tabs-data-ditolak" aria-selected="false">Data Ditolak</a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-menunggu-diverifikasi" role="tabpanel" aria-labelledby="custom-tabs-menunggu-diverifikasi-tab">
                                    <table id="table-data-menunggu" style="width: 100%;" class="table table-bordered table-striped">
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
                                <div class="tab-pane fade" id="custom-tabs-data-diterima" role="tabpanel" aria-labelledby="custom-tabs-data-diterima-tab">
                                    <table id="table-data-diterima" style="width: 100%;" class="table table-bordered table-striped">
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
                                <div class="tab-pane fade" id="custom-tabs-data-ditolak" role="tabpanel" aria-labelledby="custom-tabs-data-ditolak-tab">
                                    <table id="table-data-ditolak" style="width: 100%;" class="table table-bordered table-striped">
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
                        </div>
                        <!-- /.card -->
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



        let table_data_menunggu = $("#table-data-menunggu").DataTable({
            processing: true,
            serverSide: true,
            "order": [],
            ordering: false,
            "aaSorting": [],
            ajax: BASE_URL + "backend/validasi/json/menunggu",
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
                width: "40px",
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
        $(document).on("click", "[bVerifikasi]", function(e) {
            let id = $(this).attr("bVerifikasi");
            openModal({
                classDialog: 'modal-lg',
                title: "Verifikasi Pembayaran",
                src: BASE_URL + "backend/validasi/modal-validasi/" + id,
                buttonClose: {
                    title: "Tutup",
                    action: function() {},
                },
                buttonDone: {
                    autoClose: false,
                    title: "Submit",
                    action: function(modal) {
                        let $form = $(modal).find('form');
                        let $buttonDone = $(modal).find('[bmodaldone]');
                        let $buttonClose = $(modal).find('[bmodalclose]');

                        if ($buttonDone.attr("submit") == "false") {
                            return;
                        }

                        $buttonDone.attr("submit", "false");
                        $buttonDone.html('<i class="fa fa-spinner fa-spin"></i>');

                        $.ajax({
                                type: "POST",
                                url: $form.attr('action'),
                                data: $form.serialize(),
                                dataType: "json",
                                success: function(response) {
                                    $buttonClose.trigger('click');
                                    table_data_menunggu.ajax.reload();
                                    table_data_diterima.ajax.reload();
                                    table_data_ditolak.ajax.reload();
                                    Swal.fire({
                                        icon: response.icon,
                                        title: response.message,
                                        showConfirmButton: false,
                                        showCloseButton: true,
                                    });
                                }
                            })
                            .always(function(e) {
                                $buttonDone.attr("Submit", "true");
                                $buttonDone.html("Submit");
                            })
                    }
                },
            });
        });

        $(document).on("change", "[name='status']", function(e) {
            let status = $('[name="status"]:checked').val();
            let $alasan = $('[name="alasan-penolakan"]');

            if (status == 'gagal') {
                $alasan.attr('disabled', false);
                $("#content-alasan-penolakan").show();
            } else {
                $("#content-alasan-penolakan").val('');
                $alasan.attr('disabled', true);
                $("#content-alasan-penolakan").hide();

            }
        });
        let table_data_diterima = $("#table-data-diterima").DataTable({
            processing: true,
            serverSide: true,
            "order": [],
            ordering: false,
            "aaSorting": [],
            ajax: BASE_URL + "backend/validasi/json/diterima",
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
                width: "40px",
            }, {
                targets: -2,
                width: '100px',
                className: 'text-center',
            }, ],
        });
        let table_data_ditolak = $("#table-data-ditolak").DataTable({
            processing: true,
            serverSide: true,
            "order": [],
            ordering: false,
            "aaSorting": [],
            ajax: BASE_URL + "backend/validasi/json/ditolak",
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
                width: "40px",
            }, {
                targets: -2,
                width: '100px',
                className: 'text-center',
            }, ],
        });

        $(document).on('click', '[bSendMail]', function(e) {
            let id = $(this).attr('bSendMail');
            let tipe = $(this).data('tipe')

            Swal.fire({
                icon: "info",
                title: "Mengirim email...",
                text: 'Harap menunggu',
                showConfirmButton: false,
                showCloseButton: false,
                timer: false,
            });

            $.ajax({
                    type: "POST",
                    url: BASE_URL + 'backend/validasi/send-mail/' + tipe,
                    data: {
                        "id": id
                    },
                    dataType: "json",
                })
                .done(function(response) {
                    Swal.close();
                    Swal.fire({
                        icon: response.icon,
                        title: response.message,
                        showConfirmButton: false,
                    });

                    table_data_diterima.ajax.reload();
                    table_data_ditolak.ajax.reload();
                });
        })
    });
</script>

<?php $this->endSection() ?>
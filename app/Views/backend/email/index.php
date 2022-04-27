<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Konfigurasi email</h1>
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
                            <form method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $setting_email['email_email'] ?? null ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" value="<?= $setting_email['email_password'] ?? null ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm-password">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm-password" value="<?= $setting_email['email_password'] ?? null ?>">
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" id="btnSubmitEmail" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
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

        $("form").submit(function(e) {
            e.preventDefault();
            $("#form-message").empty();
            let $button = $(this).find('[type="submit"]');
            if ($button.attr("submit") == "false") {
                return;
            }

            $button.attr("submit", "false");
            $button.html('<i class="fa fa-spinner fa-spin"></i>');

            let formData = new FormData($(this)[0]);
            $.ajax({
                processData: false,
                contentType: false,
                type: "POST",
                url: BASE_URL + "/backend/email",
                data: formData,
                success: function(response) {
                    if (!response.success) {
                        showNotifBackendSm(response.message, response.form_message, "red");
                    } else {
                        showNotifBackendSm(response.message, response.form_message, "green");

                    }
                },
            }).always(function(e) {
                $button.attr("submit", "true");
                $button.html("Simpan");
            });

        });
    });
</script>
<?php $this->endSection() ?>
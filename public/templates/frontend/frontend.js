$(document).ready(function () {
  materialKit.initFormExtendedDatetimepickers();

  $("#btnSubmitPendaftaran").click(function (e) {
    $("#form-message").empty();

    let $form = $(this).closest("form");
    let $button = $(this);

    if ($button.attr("submit") == "false") {
      return;
    }

    $button.attr("submit", "false");
    $button.html('<i class="fa fa-spinner fa-spin"></i>');

    let formData = new FormData($form[0]);

    $.ajax({
      processData: false,
      contentType: false,
      type: "POST",
      url: BASEURL + "/daftar",
      data: formData,
      success: function (response) {
        if (!response.success) {
          showNotifMd("Pendaftaran gagal", response.form_message, "red");
        } else {
          if (response.redirect) {
            $button.remove();
            window.location.href = response.redirect;
          }
        }
      },
    }).always(function (e) {
      $button.attr("submit", "true");
      $button.html("DAFTAR SEKARANG");
    });
  });
  setTotalPembayaran();

  $('input[name^="id_workshop"]').change(setTotalPembayaran);
  $('input[name="id_event_simposium"]').change(setTotalPembayaran);

  $("#btnSubmitValidasiPembayaran").click(function (e) {
    $("#form-message").empty();

    let $form = $(this).closest("form");
    let $button = $(this);

    if ($button.attr("submit") == "false") {
      return;
    }

    $button.attr("submit", "false");
    $button.html('<i class="fa fa-spinner fa-spin"></i>');

    let formData = new FormData($form[0]);

    $.ajax({
      processData: false,
      contentType: false,
      type: "POST",
      url: BASEURL + "/validasi-pembayaran",
      data: formData,
      success: function (response) {
        if (!response.success) {
          showNotifMd("Validasi gagal", response.form_message, "red");
        } else {
          if (response.redirect) {
            $button.remove();
            window.location.href = response.redirect;
          }
        }
      },
    }).always(function (e) {
      $button.attr("submit", "true");
      $button.html("SUBMIT");
    });
  });

  // end of document ready jquery
});

function setTotalPembayaran() {
  let $spanTotalPembayaran = $("span#total-pembayaran");
  let $inputTotalPembayaran = $('input[name="total_pembayaran"]');
  let $inputKodeUnik = $('input[name="kode_unik_pembayaran"]');
  let $inputBiaya = $('input[name="biaya"]');
  let $checkboxesWorkshop = $('input[name^="id_workshop"]');

  let hargaSimposium =
    $('input[name="id_event_simposium"]:checked').data("harga") ?? 0;
  let hargaKodeUnik = $('input[name="kode_unik_pembayaran"]').val();
  let hargaWorkshop = 0;

  $.each($checkboxesWorkshop, function (i, v) {
    if ($(v).is(":checked")) {
      hargaWorkshop += $(v).data("biaya");
    }
  });

  let totalPembayaran = parseInt(hargaSimposium) + parseInt(hargaWorkshop);

  $inputBiaya.val(totalPembayaran);

  totalPembayaran = totalPembayaran + parseInt(hargaKodeUnik);

  $inputTotalPembayaran.val(totalPembayaran);
  $spanTotalPembayaran.text(formatRupiah(totalPembayaran.toString()));
}
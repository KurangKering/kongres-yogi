$(document).ready(function () {
  $("#select-hotel").change(function (e) {
    let id_hotel = $(this).find("option:selected").val();
    $("#div-tanggal-menginap").addClass("hide");
    $("#div-lama-menginap").addClass("hide");
    $("#select-jenis-kamar").find("option").not(":first").remove();
    $("#select-jenis-kamar").val("");
    $("#select-tanggal-menginap").find("option").not(":first").remove();
    $("#select-tanggal-menginap").val("");
    $("#select-lama-menginap").find("option").not(":first").remove();
    $("#select-lama-menginap").val("");

    if (id_hotel == "0") {
      $("#div-jenis-kamar").addClass("hide");
      return;
    }

    $.ajax({
      type: "GET",
      url: BASEURL + "daftar/lookup-jenis-kamar",
      data: {
        id_hotel: id_hotel,
      },
      dataType: "json",
      success: function (response) {
        if (response.option_jenis_kamar) {
          for (let i = 0; i < response.option_jenis_kamar.length; i++) {
            $("#select-jenis-kamar").append(
              $("<option>", {
                value: response.option_jenis_kamar[i]["value"],
                text: response.option_jenis_kamar[i]["text"],
              })
            );
          }
        }
      },
    }).always(function (e) {
      $("#div-jenis-kamar").removeClass("hide");
    });
  });
  $("#select-jenis-kamar").change(function (e) {
    let id_jenis_kamar_hotel = $(this).find("option:selected").val();

    $("#div-lama-menginap").addClass("hide");
    $("#select-tanggal-menginap").find("option").not(":first").remove();
    $("#select-tanggal-menginap").val("");
    $("#select-lama-menginap").find("option").not(":first").remove();
    $("#select-lama-menginap").val("");

    $.ajax({
      type: "GET",
      url: BASEURL + "daftar/lookup-tanggal-menginap",
      data: {
        id_jenis_kamar_hotel: id_jenis_kamar_hotel,
      },
      dataType: "json",
      success: function (response) {
        if (response.option_tanggal_menginap) {
          $("#option-tanggal-menginap").empty();
          populateOptionTanggalMenginap(response.option_tanggal_menginap);
          $("#div-tanggal-menginap").removeClass("hide");
        }
      },
    });
  });

  $("#select-tanggal-menginap").change(function (e) {
    let id_jenis_kamar_hotel = $("#select-jenis-kamar")
      .find("option:selected")
      .val();
    let tanggal = $(this).find("option:selected").val();

    $("#select-lama-menginap").find("option").not(":first").remove();
    $("#select-lama-menginap").val("");

    $.ajax({
      type: "GET",
      url: BASEURL + "daftar/lookup-lama-menginap",
      data: {
        id_jenis_kamar_hotel: id_jenis_kamar_hotel,
        tanggal: tanggal,
      },
      dataType: "json",
      success: function (response) {
        if (response.option_lama_menginap) {
          $("#option-lama-menginap").empty();
          $("#div-lama-menginap").removeClass("hide");

          if (response.option_lama_menginap.length > 0) {
            populateOptionLamaMenginap(response.option_lama_menginap);
          }
        }
      },
    });
  });

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

          if (response.callback) {
            let callback = response.callback;
            if (callback.option_lama_menginap) {
              $("#select-lama-menginap").find("option").not(":first").remove();
              $("#select-lama-menginap").val("");
              populateOptionLamaMenginap(callback.option_lama_menginap);
            }

            if (callback.option_tanggal_menginap) {
              $("#select-tanggal-menginap")
                .find("option")
                .not(":first")
                .remove();
              $("#select-tanggal-menginap").val("");
              populateOptionTanggalMenginap(callback.option_tanggal_menginap);
              $("#div-lama-menginap").addClass("hide");
            }
          }
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
  $("#select-hotel").change(setTotalPembayaran);
  $("#select-jenis-kamar").change(setTotalPembayaran);
  $("#select-tanggal-menginap").change(setTotalPembayaran);
  $("#select-lama-menginap").change(setTotalPembayaran);

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

function populateOptionLamaMenginap(option_lama_menginap) {
  for (let i = 0; i < option_lama_menginap.length; i++) {
    $("#select-lama-menginap").append(
      $("<option>", {
        value: option_lama_menginap[i]["value"],
        text: option_lama_menginap[i]["text"],
        data: {
          harga: option_lama_menginap[i]["harga"],
        },
      })
    );
  }
}
function populateOptionTanggalMenginap(option_tanggal_menginap) {
  for (let i = 0; i < option_tanggal_menginap.length; i++) {
    $("#select-tanggal-menginap").append(
      $("<option>", {
        value: option_tanggal_menginap[i]["value"],
        text: option_tanggal_menginap[i]["text"],
      })
    );
  }
}

function setTotalPembayaran() {
  let $spanTotalPembayaran = $("span#total-pembayaran");
  let $inputTotalPembayaran = $('input[name="total_pembayaran"]');
  let $inputKodeUnik = $('input[name="kode_unik_pembayaran"]');
  let $inputBiaya = $('input[name="biaya"]');
  let $checkboxesWorkshop = $('input[name^="id_workshop"]');
  let $selectLamaMenginap = $("#select-lama-menginap").find("option:selected");

  let hargaLamaMenginap = $selectLamaMenginap.data("harga") ?? 0;
  let hargaSimposium =
    $('input[name="id_event_simposium"]:checked').data("harga") ?? 0;
  let hargaKodeUnik = $('input[name="kode_unik_pembayaran"]').val();
  let hargaWorkshop = 0;

  $.each($checkboxesWorkshop, function (i, v) {
    if ($(v).is(":checked")) {
      hargaWorkshop += $(v).data("biaya");
    }
  });

  let totalPembayaran =
    parseInt(hargaSimposium) +
    parseInt(hargaWorkshop) +
    parseInt(hargaLamaMenginap);

  $inputBiaya.val(totalPembayaran);

  totalPembayaran = totalPembayaran + parseInt(hargaKodeUnik);

  $inputTotalPembayaran.val(totalPembayaran);
  $spanTotalPembayaran.text(formatRupiah(totalPembayaran.toString()));
}

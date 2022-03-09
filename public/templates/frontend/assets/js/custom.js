$(document).ready(function () {
  materialKit.initFormExtendedDatetimepickers();

  $("#btnSubmitPendaftaran").click(function (e) {
    let $form = $(this).closest("form");

    let formData = new FormData($form[0]);

    $.ajax({
      processData: false,
      contentType: false,
      type: "POST",
      url: BASEURL + "/daftar",
      data: formData,
      success: function (response) {},
    });
  });
  setTotalPembayaran();

  $('input[name^="id_workshop"]').change(setTotalPembayaran);
  $('input[name="id_event_simposium"]').change(setTotalPembayaran);
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

  let totalPembayaran =
    parseInt(hargaSimposium) +
    parseInt(hargaKodeUnik) +
    parseInt(hargaWorkshop);
  $inputTotalPembayaran.val(totalPembayaran);
  $spanTotalPembayaran.text(formatRupiah(totalPembayaran.toString()));
}

function formatRupiah(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

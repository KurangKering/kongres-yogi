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

function showNotifMd(title, content, type) {
  showNotification(title, content, type, "medium");
}
function showNotifSm(title, content, type) {
  showNotification(title, content, type, "small");
}
function showNotifBackendMd(title, content, type) {
  showNotificationBackend(title, content, type, "medium");
}
function showNotifBackendSm(title, content, type) {
  showNotificationBackend(title, content, type, "small");
}

function showNotificationBackend(title, content, type = "red", size = "medium") {
  let icon = "";
  if (type == "red") {
    icon = "fas fa-exclamation";
  } else if (type == "green") {
    icon = "fas fa-check";
  } 
  $.alert({
    title: title,
    icon: icon,
    type: type,
    typeAnimated: true,
    columnClass: size,
    content: content,
    scrollToPreviousElement: false,
    backgroundDismiss: true,
  });
}
function showNotification(title, content, type = "red", size = "medium") {
  let icon = "";
  if (type == "red") {
    icon = "fa fa-warning";
  }
  $.alert({
    title: title,
    icon: icon,
    type: type,
    typeAnimated: true,
    columnClass: size,
    content: content,
    scrollToPreviousElement: false,
    backgroundDismiss: true,
  });
}

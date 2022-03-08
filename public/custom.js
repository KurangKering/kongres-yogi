$(document).ready(function () {
  let table_data_pendaftaran = $("#table-data-pendaftaran").DataTable({
    processing: true,
    serverSide: true,
    ajax: BASE_URL + "backend/data-pendaftaran/json-dt",
    columns: [
      {
        data: "id",
      },
      {
        data: "tanggal_pendaftaran",
      },
      {
        data: "nama",
      },
      {
        data: "no_hp",
      },
      {
        data: "kategori",
      },
      {
        data: "status",
      },
    ],
    columnDefs: [
      {
        targets: -1,
      },
    ],
  });

  let table_data_validasi = $("#table-data-validasi").DataTable({
    processing: true,
    serverSide: true,
    ajax: BASE_URL + "backend/data-validasi/json-dt",
    columns: [
      {
        data: "id",
      },
      {
        data: "tanggal_validasi",
      },
      {
        data: "nama",
      },
      {
        data: null,
      },
      {
        data: null,
      },
      {
        data: null,
      },
    ],
    columnDefs: [
      {
        targets: -1,
      },
    ],
  });

  let table_data_simposium = $("#table-data-simposium").DataTable({
    processing: true,
    serverSide: true,
    ajax: BASE_URL + "backend/data-simposium/json-dt",
    columns: [
      {
        data: "id",
      },
      {
        data: "kategori",
      },
      {
        data: "hybrid",
      },
      {
        data: 'action',
      },
    ],
    columnDefs: [
      {
        targets: -1,
      },
    ],
  });

  let table_data_event_simposium = $("#table-data-event-simposium").DataTable({
    processing: true,
    serverSide: true,
    order : [],
    ajax: BASE_URL + "backend/data-event-simposium/json-dt",
    columns: [
      {
        data: "id",
      },
      {
        data: "kategori",
      },
      {
        data: "hybrid",
      },
      {
        data: 'tipe_pendaftaran',
      },
      {
        data: 'harga',
      },
      {
        data: 'waktu_pendaftaran',
      },
      {
        data: 'action',
      },
    ],
    columnDefs: [
      {
        targets: -1,
      },
    ],
  });

});

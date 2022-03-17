function openModal(param) {
  if (param.src) {
    var modal = $("#modal-ajax");

    if (param.classDialog != "undefined") {
      var mDialog = modal.find(".modal-dialog");
      mDialog.removeClass();
      mDialog.addClass("modal-dialog");
      mDialog.addClass(param.classDialog);
    }

    if (typeof param.onShow == "function") {
      param.onShow(modal);
    }

    modal.find(".modal-title").html(param.title);
    modal.find("[bModalClose]").html(param.buttonClose.title);
    modal.find("[bModalDone]").html(param.buttonDone.title);
    modal.find(".modal-body").html($("#loading-spin").html());

    modal.modal("show");

    var elm_button_done = modal.find("[bModalDone]");
    if (param.buttonDone == false) {
      elm_button_done.hide();
    } else {
      elm_button_done.show();
    }
    // loader(true);

    var req = "";

    if (typeof param.post != "undefined") {
      req = $.post(param.src, param.post);
    } else {
      req = $.get(param.src);
    }

    req
      .done(function (out) {
        modal.find(".modal-body").html(out);
        modal
          .find("[bModalClose]")
          .unbind("click")
          .click(function () {
            if (typeof param.buttonClose != "undefined") {
              if (typeof param.buttonClose.action != "undefined") {
                param.buttonClose.action();
              }
            }
            modal.find(".modal-title").html("");
            modal.find("[bModalClose]").html("");
            modal.find("[bModalDone]").html("");
            modal.find(".modal-body").html("");
            $(this).unbind("click");
          });
        if (param.buttonDone != false) {
          modal
            .find("[bModalDone]")
            .unbind("click")
            .click(function () {
              param.buttonDone.action(modal);
              if (param.buttonDone.autoClose == false) {
              } else {
                modal.find("[bModalClose]").click();
                $(this).unbind("click");
              }
            });
        }
      })
      .fail(function (x) {
        // setNotify({
        //   title: x.status,
        //   text: x.statusText,
        //   image: ASSETS + "global/img/icon/64/error.png",
        // });
      })
      .always(function () {
        modal.find(".modal-body").empty();

        // loader(false);
      });
  } else {
    // console.log("Error: Link target belum ditentukan");
  }
}

$("[link]").click(function (e) {
  let link = $(this).attr("link");
  window.location.href = link;
});

$(document).ready(function () {
  let table_data_pendaftaran = $("#table-data-pendaftaran").DataTable({
    processing: true,
    serverSide: true,
    ajax: BASE_URL + "backend/pendaftaran/json-pendaftaran",
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
        data: "action",
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
    ajax: BASE_URL + "backend/validasi/json-validasi-sudah-bayar",
    columns: [
      {
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
        data: "status",
      },
      {
        data: "action",
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
    ajax: BASE_URL + "backend/simposium/json-dt",
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
        data: "action",
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
    order: [],
    ajax: BASE_URL + "backend/event-simposium/json-event-simposium",
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
    columnDefs: [
      {
        targets: -1,
      },
    ],
  });

  $(document).on("click", "[bVerifikasi]", function () {
    let $button = $(this);
    Swal.fire({
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
        let formData = new FormData();
        formData.append("id", $button.attr("bVerifikasi"));
        formData.append("status", status);

        $.ajax({
          type: "POST",
          url: BASE_URL + "backend/validasi/validasi",
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (response) {
            if (response.success) {
              Swal.fire({
                icon: "success",
                title: "Sukses",
                text: response.message,
              });

              table_data_validasi.ajax.reload();
            }
          },
        });
      }
    });
  });
});

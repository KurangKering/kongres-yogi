var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

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
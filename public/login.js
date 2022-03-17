//  login page

$("#btnSignIn").click(function (e) {
  let $form = $(this).closest("form");
  let $button = $(this);

  if ($button.attr("submit") == "false") {
    return;
  }
  $button.attr("submit", "false");
  $button.html('<i class="fa fa-spinner fa-spin"></i>');

  let data = new FormData($form[0]);
  $.ajax({
    processData: false,
    contentType: false,
    type: "POST",
    url: BASE_URL + "/login",
    data: data,
    headers: {
      "X-Requested-With": "XMLHttpRequest",
    },
    success: function (response) {
      if (response.success) {
        window.location.href = response.redirect;
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: response.message,
          showConfirmButton: false,
          timer: 1500,
        });
      }
    },
  }).always(function (e) {
    $button.attr("submit", "true");
    $button.html("Sign in");
  });
});

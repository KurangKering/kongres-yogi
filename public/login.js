//  login page

$("#btnSignIn").click(function (e) {
  $("#fSignIn").submit();
});

$("#fSignIn").submit(function (e) {
  e.preventDefault();
  let data = new FormData($(this)[0]);

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
      }
    },
  });
});

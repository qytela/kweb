var password = $("#val-password_");
var new_password = $("#val-password_update");
var c_new_password = $("#val-password_update_2");

var MODAL_DIV_PASSWORD = $("#modalDivPassword");
var SAVE_PASSWORD = $("#save-password");

$("#password").on("click", function() {
  MODAL_DIV_PASSWORD.modal("show");
  SAVE_PASSWORD.unbind().on("click", function() {
    onPostPassword();
  });
});

function onPostPassword() {
  fetchData("password/update_", "POST", {
    "val-password_": password.val(),
    "val-password_update": new_password.val(),
    "val-password_update_2": c_new_password.val()
  })
    .then(function(response) {
      console.log(response);
    });
}
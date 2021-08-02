var password = $("#val-password_");
var new_password = $("#val-password_update");
var c_new_password = $("#val-password_update_2");

var MODAL_DIV_PASSWORD = $("#modalDivPassword");
var SAVE_PASSWORD = $("#save-password");

$("#password").on("click", function() {
  MODAL_DIV_PASSWORD.modal("show");
  SAVE_PASSWORD.unbind().on("click", function() {
    onValidationPassword();
  });
});

function onValidationPassword() {
  resetErrors("errors-password");

  if (!password.val()) {
    errors.push("Masukkan Password lama");
  } else if (password.val().length < 4) {
    errors.push("Password lama tidak boleh kurang lebih dari 4 karakter");
  }

  if (!new_password.val()) {
    errors.push("Masukkan Password baru");
  } else if (new_password.val().length < 4) {
    errors.push("Password baru tidak boleh kurang lebih dari 4 karakter");
  } else if (new_password.val() !== c_new_password.val()) {
    errors.push("Konfirmasi Password baru tidak sama");
  }

  if (errors.length > 0) {
    var msg = errors.map(function(item) { return `- ${item}</br>` }).join("");
    return showErrors(msg, "errors-password");
  }

  showLoadingPassword(true);
  onPostPassword();
}

function onPostPassword() {
  fetchData("password/update_", "POST", {
    "val-password_": password.val(),
    "val-password_update": new_password.val(),
    "val-password_update_2": c_new_password.val()
  })
    .then(function(response) {
      if (response.success) {
        SwalFireSuccess();
        resetErrors("errors-password");
        MODAL_DIV_PASSWORD.modal("hide");
      } else {
        SwalFireError("Password lama salah");
      }
    })
    .finally(function() {
      showLoadingPassword(false);
    });
}

function showLoadingPassword(boolean) {
  if (boolean) {
    $("#submit-password").addClass("d-none");
    $("#loading-password").removeClass("d-none");
  } else {
    $("#submit-password").removeClass("d-none");
    $("#loading-password").addClass("d-none");
  }
}
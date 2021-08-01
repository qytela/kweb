var nama = $("#val-nama");
var username = $("#val-username");
var password = $("#val-password");
var password_confirm = $("#val-password_confirm");
var role = $("#val-id_role");

var MODAL_DIV_USER_LABEL = $("#modalDivUserLabel");
var MODAL_DIV_USER = $("#modalDivUser");
var SAVE = $("#save");
var ACTION_USER = $("#action-user");
var TABLE_USER = $("#table-user");
var NAMA = $("#nama");
var USERNAME = $("#username");
var PASSWORD = $("#password");
var PASSWORD_CONFIRM = $("#password-confirm");
var ROLE = $("#role");

$("#add-item-user").on("click", function() {
  resetErrors();
  resetFields([nama, username, password, password_confirm, role]);
  showHideFields([NAMA, USERNAME, PASSWORD, PASSWORD_CONFIRM, ROLE], "show");

  MODAL_DIV_USER_LABEL.text("Add User");
  MODAL_DIV_USER.modal("show");

  SAVE.unbind().on("click", function() {
    ACTION_USER.attr("action", "user/save_");
    onValidationUser({ type: "create" });
  });
});

TABLE_USER.on("click", "#item-edit", function() {
  var id = $(this).attr("data");

  resetErrors();
  resetFields([nama, username, password, password_confirm, role]);
  showHideFields([NAMA, USERNAME, ROLE], "show");
  showHideFields([PASSWORD, PASSWORD_CONFIRM], "hide");

  fetchData("user/edit_", "POST", { id })
    .then(function(response) {
      nama.val(response.nama);
      username.val(response.username);
      role.val(response.id_role).trigger("change");

      MODAL_DIV_USER_LABEL.text("Update User");
      MODAL_DIV_USER.modal("show");
      SAVE.unbind().on("click", function() {
        ACTION_USER.attr("action", "user/update_");
        onValidationUser({ type: "update", id: response.id });
      });
    });
})

TABLE_USER.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Tracking!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("user/delete_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_USER);
            }
          });
      }
    });
});

TABLE_USER.on("click", "#item-edit-password", function() {
  var id = $(this).attr("data");

  resetErrors();
  resetFields([password, password_confirm]);
  showHideFields([PASSWORD, PASSWORD_CONFIRM], "show");
  showHideFields([NAMA, USERNAME, ROLE], "hide");

  MODAL_DIV_USER_LABEL.text("Update Password");
  MODAL_DIV_USER.modal("show");
  SAVE.unbind().on("click", function() {
    ACTION_USER.attr("action", "user/password_");
    onValidationUser({ type: "update-password", id });
  });
});

function onValidationUser(options) {
  resetErrors();

  if (options && options.type === "create" || options.type === "update") {
    if (!nama.val()) errors.push("Masukkan Nama");
  
    if (!username.val()) {
      errors.push("Masukkan Username");
    } else if (username.val().length < 3) {
      errors.push("Username tidak boleh kurang lebih dari 3 karakter");
    }
  }

  if (options && options.type === "create" || options.type === "update-password") {
    if (!password.val()) {
      errors.push("Masukkan Password");
    } else if (password.val().length < 4) {
      errors.push("Password tidak boleh kurang lebih dari 4 karakter");
    } else if (password.val() !== password_confirm.val()) {
      errors.push("Konfirmasi Password tidak sama");
    }
  }

  if (options && options.type === "create" || options.type === "update") {
    if (!role.val()) errors.push("Pilih Hak Akses");
  }
  if (errors.length > 0) {
    var msg = errors.map(function(item) { return `- ${item}</br>` }).join("");
    return showErrors(msg);
  }

  showLoading(true);
  onPostUser(options);
}

function onPostUser(options) {
  if (options && options.type === "update-password") {
    var data = {
      "val-password": password.val(),
      "val-password_confirm": password_confirm.val(),
    }
  } else {
    var data = {
      "val-nama": nama.val(),
      "val-username": username.val(),
      "val-password": password.val(),
      "val-password_confirm": password_confirm.val(),
      "val-id_role": role.val()
    }
  }

  if (options && options.type === "update" || options.type === "update-password") data["val-id"] = options.id;

  showLoading(true);

  fetchData(ACTION_USER.attr("action"), "POST", { ...data })
    .then(function(response) {
      if (response.success) {
        SwalFireSuccess();
        resetErrors();
        refreshDataTables(TABLE_USER);
        MODAL_DIV_USER.modal("hide");
      }
    })
    .finally(function() {
      showLoading(false);
    });
}
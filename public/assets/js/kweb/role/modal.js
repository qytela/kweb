var nama = $("#val-nama");

var MODAL_DIV_ROLE_LABEL = $("#modalDivRoleLabel");
var MODAL_DIV_ROLE = $("#modalDivRole");
var SAVE_ROLE = $("#save-role");
var SAVE_ROLE_PERMISSION = $("#save-role-permission");
var ACTION_ROLE = $("#action-role");
var TABLE_ROLE = $("#table-role");

$("#add-item-role").on("click", function() {
  resetErrors();
  resetFields([nama]);

  MODAL_DIV_ROLE_LABEL.text("Add Role");
  MODAL_DIV_ROLE.modal("show");
  SAVE_ROLE.unbind().on("click", function() {
    ACTION_ROLE.attr("action", "role/save_");
    onValidationPost();
  })
});

TABLE_ROLE.on("click", "#item-edit", function() {
  var id = $(this).attr("data");

  resetErrors();
  resetFields([nama]);

  fetchData("role/edit_", "POST", { id })
    .then(function(response) {
      nama.val(response.nama);

      MODAL_DIV_ROLE_LABEL.text("Update Role");
      MODAL_DIV_ROLE.modal("show");
      SAVE_ROLE.unbind().on("click", function() {
        ACTION_ROLE.attr("action", "role/update_");
        onValidationPost({ type: "update", id });
      });
    });
});

TABLE_ROLE.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Role!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("role/delete_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_ROLE);
            }
          });
      }
    });
});

SAVE_ROLE_PERMISSION.on("click", function() {
  var id = SAVE_ROLE_PERMISSION.attr("id_state");
  var data_menu = [];
  $('input[name="check_menus"]:checked').each(function() {
      data_menu.push($(this).val());
  });

  fetchData("role/save_role_menu_", "POST", { id, data_menu })
    .then(function(response) {
      if (response.success) {
        SwalFireSuccess();
      }
    });
});

function onValidationPost(options) {
  resetErrors();

  if (!nama.val()) errors.push("Masukkan Nama Role");
  if (errors.length > 0) {
    var msg = errors.map(function(item) { return `- ${item}</br>` }).join("");
    return showErrors(msg);
  }

  showLoading(true);
  onPostRole(options);
}

function onPostRole(options) {
  var data = {
    "val-nama": nama.val()
  }

  if (options && options.type === "update") data["val-id"] = options.id;

  fetchData(ACTION_ROLE.attr("action"), "POST", { ...data })
    .then(function(response) {
      if (response.success) {
        SwalFireSuccess();
        resetErrors();
        refreshDataTables(TABLE_ROLE);
        MODAL_DIV_ROLE.modal("hide");
      }
    })
    .finally(function() {
      showLoading(false);
    });
}
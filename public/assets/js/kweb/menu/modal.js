var nama = $("#val-nama");
var icon = $("#val-icon");
var label = $("#val-label");
var url = $("#val-url");
var urutan = $("#val-urutan");

var MODAL_DIV_MENU_LABEL = $("#modalDivMenuLabel");
var MODAL_DIV_MENU = $("#modalDivMenu");
var SAVE = $("#save");
var ACTION_MENU = $("#action-menu");
var TABLE_MENU = $("#table-menu");

$("#add-item-menu").on("click", function() {
  resetErrors();
  resetFields([nama, icon, label, url, urutan]);

  MODAL_DIV_MENU_LABEL.text("Add Menu");
  MODAL_DIV_MENU.modal("show");
  SAVE.unbind().on("click", function() {
    ACTION_MENU.attr("action", "menu/save_");
    onValidationMenu();
  })
});

TABLE_MENU.on("click", "#item-edit", function() {
  var id = $(this).attr("data");

  resetErrors();
  resetFields([nama, icon, label, url, urutan]);

  fetchData("menu/edit_", "POST", { id })
    .then(function(response) {
      nama.val(response.nama);
      icon.val(response.icon);
      label.val(response.label);
      url.val(response.url);
      urutan.val(response.urutan);

      MODAL_DIV_MENU_LABEL.text("Update Menu");
      MODAL_DIV_MENU.modal("show");
      SAVE.unbind().on("click", function() {
        ACTION_MENU.attr("action", "menu/update_");
        onValidationMenu({ type: "update", id });
      });
    });
});

TABLE_MENU.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Menu!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("menu/delete_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_MENU);
            }
          });
      }
    });
});

function onValidationMenu(options) {
  resetErrors();

  if (!nama.val()) errors.push("Masukkan Nama Menu");
  if (!icon.val()) errors.push("Masukkan Icon");
  if (!label.val()) errors.push("Masukkan Label");
  if (!url.val()) errors.push("Masukkan URL");
  if (!urutan.val()) errors.push("Masukkan Urutan");
  if (errors.length > 0) {
    var msg = errors.map(function(item) { return `- ${item}</br>` }).join("");
    return showErrors(msg);
  }

  showLoading(true);
  onPostRole(options);
}

function onPostMenu(options) {
  var data = {
    "val-nama": nama.val(),
    "val-icon": icon.val(),
    "val-label": label.val(),
    "val-url": url.val(),
    "val-urutan": urutan.val()
  }

  if (options && options.type === "update") data["val-id"] = options.id;

  fetchData(ACTION_MENU.attr("action"), "POST", { ...data })
    .then(function(response) {
      if (response.success) {
        SwalFireSuccess();
        resetErrors();
        refreshDataTables(TABLE_MENU);
        MODAL_DIV_MENU.modal("hide");
      }
    })
    .finally(function() {
      showLoading(false);
    });
}
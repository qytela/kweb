var nama = $("#val-nama");
var keterangan = $("#val-keterangan");
var users = $("#val-users");

var MODAL_DIV_KASUS_LABEL = $("#modalDivKasusLabel");
var MODAL_DIV_KASUS = $("#modalDivKasus");
var SAVE = $("#save");
var ACTION_KASUS = $("#action-kasus");
var TABLE_KASUS = $("#table-kasus");
var TABLE_KASUS_RECYCLE = $("#table-kasus-recycle");

$("#add-item-kasus").on("click", function() {
  resetErrors();
  resetFields([nama, keterangan, users]);

  MODAL_DIV_KASUS_LABEL.text("Add Kasus");
  MODAL_DIV_KASUS.modal("show");
  SAVE.unbind().on("click", function() {
    ACTION_KASUS.attr("action", "kasus/save_");
    onValidationKasus();
  });
});

TABLE_KASUS.on("click", "#item-edit", function() {
  var id = $(this).attr("data");

  resetErrors();
  resetFields([nama, keterangan, users]);

  fetchData("kasus/edit_", "POST", { id })
    .then(function(response) {
      nama.val(response.nama);
      keterangan.val(response.keterangan);
      users.val(response.users).trigger("change");

      MODAL_DIV_KASUS_LABEL.text("Update Kasus");
      MODAL_DIV_KASUS.modal("show");
      SAVE.unbind().on("click", function() {
        ACTION_KASUS.attr("action", "kasus/update_");
        onValidationKasus({ type: "update", id });
      });
    });
});

TABLE_KASUS.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Kasus!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("kasus/delete_soft_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_KASUS);
            }
          });
      }
    });
});

TABLE_KASUS_RECYCLE.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Kasus!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("kasus/delete_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_KASUS_RECYCLE);
            }
          });
      }
    });
});

TABLE_KASUS_RECYCLE.on("click", "#item-recycle", function() {
  var id = $(this).attr("data");

  SwalFireRestore({ title: "Anda Yakin?", text: "Restore data Kasus!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("kasus/restore_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_KASUS_RECYCLE);
            }
          });
      }
    });
});

function onValidationKasus(options) {
  resetErrors();

  if (!nama.val()) errors.push("Masukkan Kasus");
  if (users.val().length === 0) errors.push("Pilih Users");
  if (errors.length > 0) {
    var msg = errors.map(function(item) { return `- ${item}</br>` }).join("");
    return showErrors(msg);
  }

  showLoading(true);

  if (options && options.type === "update") {
    onPostKasus(options);
  } else {
    fetchData("kasus/cek_kasus_", "POST", { "val-nama": nama.val() })
      .then(function(response) {
        if (!response) {
          return showErrors("- Kasus sudah ada, silahkan hubungi admin kasus!");
        }
        onPostKasus(options)
      })
      .finally(function() {
        showLoading(false);
      });
  }
}

function onPostKasus(options) {
  var data = {
    "val-nama": nama.val(),
    "val-keterangan": keterangan.val(),
    "val-users[]": users.val()
  }

  if (options && options.type === "update") data["val-id"] = options.id;

  fetchData(ACTION_KASUS.attr("action"), "POST", { ...data })
    .then(function(response) {
      if (response.success) {
        SwalFireSuccess();
        resetErrors();
        refreshDataTables(TABLE_KASUS);
        MODAL_DIV_KASUS.modal("hide");
      }
    })
    .finally(function() {
      showLoading(false);
    });
}
var errors = [];
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
    ACTION_KASUS.attr("action", base_url + "kasus/save_");
    onValidationKasus();
  });
});

TABLE_KASUS.on("click", "#item-edit", function() {
  var id = $(this).attr("data");

  resetErrors();
  resetFields([nama, keterangan, users]);

  $.ajax({
    url: base_url + "kasus/edit_",
    type: "POST",
    data: { id },
    dataType: "json",
    success: function(response) {
      nama.val(response.nama);
      keterangan.val(response.keterangan);
      users.val(response.users).trigger("change");
    },
    error: function(error) {
      console.error(error);
    }
  });
  MODAL_DIV_KASUS_LABEL.text("Update Kasus");
  MODAL_DIV_KASUS.modal("show");
  SAVE.unbind().on("click", function(e) {
    e.preventDefault();
    ACTION_KASUS.attr("action", base_url + "kasus/update_");
    onValidationKasus({ type: "update", id });
  });
});

TABLE_KASUS.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Kasus!" })
    .then(function(result) {
      if (result.isConfirmed) {
        $.ajax({
          url: base_url + "kasus/delete_soft_",
          type: "POST",
          data: { id },
          dataType: "json",
          success: function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_KASUS);
            }
          },
          error: function(error) {
            console.error(error);
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
        $.ajax({
          url: base_url + "kasus/delete_",
          type: "POST",
          data: { id },
          dataType: "json",
          success: function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_KASUS_RECYCLE);
            }
          },
          error: function(error) {
            console.error(error);
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
        $.ajax({
          url: base_url + "kasus/restore_",
          type: "POST",
          data: { id },
          dataType: "json",
          success: function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_KASUS_RECYCLE);
            }
          },
          error: function(error) {
            console.error(error);
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
    $.ajax({
      url: base_url + "kasus/cek_kasus_",
      type: "POST",
      data: { "val-nama": nama.val() },
      dataType: "json",
      success: function(response) {
        if (!response) {
          showLoading(false);
          return showErrors(msg);
        }
        onPostKasus(options)
      }
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

  $.ajax({
    url: ACTION_KASUS.attr("action"),
    type: "POST",
    data,
    dataType: "json",
    success: function(response) {
      if (response.success) {
        SwalFireSuccess();
        showLoading(false);
        resetErrors();
        refreshDataTables(TABLE_KASUS);
        MODAL_DIV_KASUS.modal("hide");
      }
    },
    error: function(error) {
      console.error(error);
    }
  });
}
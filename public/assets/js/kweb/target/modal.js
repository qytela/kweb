var id_kasus = $("#val-id_kasus_target");
var nik = $("#val-nik");
var no_telp = $("#val-no_telp");
var nama = $("#val-nama");
var tempat_lahir = $("#val-tempat_lahir");
var tanggal_lahir = $("#val-tanggal_lahir");
var jenis_kelamin = $("#val-jenis_kelamin");
var provinsi = $("#val-provinsi");
var kabkot = $("#val-kabkot");
var kecamatan = $("#val-kecamatan");
var kelurahan = $("#val-kelurahan");
var alamat = $("#val-alamat");

var MODAL_DIV_TARGET_LABEL = $("#modalDivTargetLabel");
var MODAL_DIV_TARGET = $("#modalDivTarget");
var SAVE = $("#save");
var ACTION_KASUS = $("#action-kasus");
var TABLE_TARGET = $("#table-target");
var TABLE_TARGET_RECYCLE = $("#table-target-recycle");
var TRACKING_LIST = $(".tracking-list");

$("#add-item-target").on("click", function() {
  resetErrors();
  resetFields([id_kasus, nik, no_telp, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, provinsi, kabkot, kecamatan, kelurahan, alamat]);

  MODAL_DIV_TARGET_LABEL.text("Add Target");
  MODAL_DIV_TARGET.modal("show");
  SAVE.unbind().on("click", function() {
    ACTION_KASUS.attr("action", base_url + "target/save_");
    onValidationTarget();
  });
});

$('select[id="val-id_kasus"]').on("change", function() {
  TRACKING_LIST.hide();
  TABLE_TARGET.DataTable().ajax.reload();
});

$('select[id="val-id_kasus-recycle"]').on("change", function() {
  TABLE_TARGET_RECYCLE.DataTable().ajax.reload();
});

TABLE_TARGET.on("click", "#item-edit", function() {
  var id = $(this).attr("data");

  resetErrors();
  resetFields([id_kasus, nik, no_telp, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, provinsi, kabkot, kecamatan, kelurahan, alamat]);

  $.ajax({
    url: base_url + "target/edit_",
    type: "POST",
    data: { id },
    dataType: "json",
    success: function(response) {
      id_kasus.val(response.id_kasus).trigger("change");
      nik.val(response.nik);
      no_telp.val(response.no_telp);
      nama.val(response.nama);
      tempat_lahir.val(response.tempat_lahir);
      tanggal_lahir.val(response.tanggal_lahir);
      jenis_kelamin.val(response.jenis_kelamin);
      alamat.val(response.alamat);
      provinsi.val(response.provinsi).trigger("change");

      setTimeout(() => {
        kabkot.val(response.kabkot).trigger("change");
      }, 500);

      getKecamatan(response.kabkot);
      setTimeout(() => {
        kecamatan.val(response.kecamatan).trigger("change");
      }, 600);

      getKelurahan(response.kecamatan);
      setTimeout(() => {
        kelurahan.val(response.kelurahan).trigger("change");
      }, 700);
    },
    error: function(error) {
      console.error(error);
    }
  });
  MODAL_DIV_TARGET_LABEL.text("Update Target");
  MODAL_DIV_TARGET.modal("show");
  SAVE.unbind().on("click", function(e) {
    e.preventDefault();
    ACTION_KASUS.attr("action", base_url + "target/update_");
    onValidationTarget({ type: "update", id });
  });
});

TABLE_TARGET.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Target!" })
    .then(function(result) {
      if (result.isConfirmed) {
        $.ajax({
          url: base_url + "target/delete_soft_",
          type: "POST",
          data: { id },
          dataType: "json",
          success: function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_TARGET);
            }
          },
          error: function(error) {
            console.error(error);
          }
        });
      }
    });
});

TABLE_TARGET_RECYCLE.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Target!" })
    .then(function(result) {
      if (result.isConfirmed) {
        $.ajax({
          url: base_url + "target/delete_",
          type: "POST",
          data: { id },
          dataType: "json",
          success: function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_TARGET_RECYCLE);
            }
          },
          error: function(error) {
            console.error(error);
          }
        });
      }
    });
});

TABLE_TARGET_RECYCLE.on("click", "#item-recycle", function() {
  var id = $(this).attr("data");

  SwalFireRestore({ title: "Anda Yakin?", text: "Restore data Target!" })
    .then(function(result) {
      if (result.isConfirmed) {
        $.ajax({
          url: base_url + "target/restore_",
          type: "POST",
          data: { id },
          dataType: "json",
          success: function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_TARGET_RECYCLE);
            }
          },
          error: function(error) {
            console.error(error);
          }
        });
      }
    });
});

function onValidationTarget(options) {
  resetErrors();

  if (!no_telp.val()) errors.push("Masukkan nomor telpon");
  if (errors.length > 0) {
    var msg = errors.map(function(item) { return `- ${item}</br>` }).join("");
    return showErrors(msg);
  }

  showLoading(true);
  onPostTarget(options);
}

function onPostTarget(options) {
  var data = {
    "val-id_kasus_target": id_kasus.val(),
    "val-nik": nik.val(),
    "val-no_telp": no_telp.val(),
    "val-nama": nama.val(),
    "val-tempat_lahir": tempat_lahir.val(),
    "val-tanggal_lahir": tanggal_lahir.val(),
    "val-jenis_kelamin": jenis_kelamin.val(),
    "val-provinsi": provinsi.val(),
    "val-kabkot": kabkot.val(),
    "val-kecamatan": kecamatan.val(),
    "val-kelurahan": kelurahan.val(),
    "val-alamat": alamat.val()
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
        refreshDataTables(TABLE_TARGET);
        MODAL_DIV_TARGET.modal("hide");
      }
    },
    error: function(error) {
      console.error(error);
    }
  });
}
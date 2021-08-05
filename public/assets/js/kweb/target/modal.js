var id_kasus = $("#val-id_kasus_target");
var id_tap = $("#val-tap_id");
var id_target_tap = $("#val-id_target_tap_id");
var nik = $("#val-nik");
var no_telp = $("#val-no_telp");
var nama = $("#val-nama");
var tempat_lahir = $("#val-tempat_lahir");
var tanggal_lahir = $("#val-tanggal_lahir");
var jenis_kelamin = $("input[name=val-jenis_kelamin]");
var jenis_kelamin_l = $("#val-jenis_kelamin-l");
var jenis_kelamin_p = $("#val-jenis_kelamin-p");
var provinsi = $("#val-provinsi");
var kabkot = $("#val-kabkot");
var kecamatan = $("#val-kecamatan");
var kelurahan = $("#val-kelurahan");
var alamat = $("#val-alamat");

var MODAL_DIV_TARGET_LABEL = $("#modalDivTargetLabel");
var MODAL_DIV_TARGET = $("#modalDivTarget");
var MODAL_DIV_TARGET_TAP = $("#modalDivTargetTap");
var SAVE = $("#save");
var SAVE_TAP = $("#save-tap");
var ACTION_TARGET = $("#action-target");
var TABLE_TARGET = $("#table-target");
var TABLE_TARGET_RECYCLE = $("#table-target-recycle");
var TRACKING_LIST = $(".tracking-list");
var TAP_ID_LIST = $("#tap-id-list");

$("#add-item-target").on("click", function() {
  resetErrors();
  resetFields([id_kasus, nik, no_telp, nama, tempat_lahir, tanggal_lahir, jenis_kelamin.filter(":checked"), provinsi, kabkot, kecamatan, kelurahan, alamat]);

  MODAL_DIV_TARGET_LABEL.text("Add Target");
  MODAL_DIV_TARGET.modal("show");
  SAVE.unbind().on("click", function() {
    ACTION_TARGET.attr("action", "target/save_");
    onValidationTarget();
  });
});

$("#restore-all-target").on("click", function() {
  var id = $('select[id="val-id_kasus-recycle"] option').filter(":selected").val();

  if (!id) return SwalFireError("Pilih kasus terlebih dahulu!");

  SwalFireRestore({ title: "Anda Yakin?", text: "Restore semua data Target!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("target/restore_all_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_TARGET_RECYCLE);
            }
          });
      }
    });
});

$("#delete-all-target").on("click", function() {
  var id = $('select[id="val-id_kasus-recycle"] option').filter(":selected").val();

  if (!id) return SwalFireError("Pilih kasus terlebih dahulu!");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus semua data Target!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("target/delete_all_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_TARGET_RECYCLE);
            }
          });
      }
    });
});

$('select[id="val-id_kasus"]').on("change", function() {
  TRACKING_LIST.hide();
  refreshDataTables(TABLE_TARGET);
});

$('select[id="val-id_kasus-recycle"]').on("change", function() {
  refreshDataTables(TABLE_TARGET_RECYCLE);
});

TABLE_TARGET.on("click", "#item-edit", function() {
  var id = $(this).attr("data");

  resetErrors();
  resetFields([id_kasus, nik, no_telp, nama, tempat_lahir, tanggal_lahir, jenis_kelamin.filter(":checked"), provinsi, kabkot, kecamatan, kelurahan, alamat]);

  fetchData("target/edit_", "POST", { id })
    .then(function(response) {
      id_kasus.val(response.id_kasus).trigger("change");
      nik.val(response.nik);
      no_telp.val(response.no_telp);
      nama.val(response.nama);
      tempat_lahir.val(response.tempat_lahir);
      tanggal_lahir.val(response.tanggal_lahir);
      alamat.val(response.alamat);
      provinsi.val(response.provinsi).trigger("change");

      if (response.jenis_kelamin === 1) {
        jenis_kelamin_l.prop("checked", true);
      } else {
        jenis_kelamin_p.prop("checked", true);
      }

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

      MODAL_DIV_TARGET_LABEL.text("Update Target");
      MODAL_DIV_TARGET.modal("show");
      SAVE.unbind().on("click", function(e) {
        e.preventDefault();
        ACTION_TARGET.attr("action", "target/update_");
        onValidationTarget({ type: "update", id });
      });
    });
});

TABLE_TARGET.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Target!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("target/delete_soft_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_TARGET);
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
        fetchData("target/delete_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_TARGET_RECYCLE);
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
        fetchData("target/restore_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_TARGET_RECYCLE);
            }
          });
      }
    });
});

id_tap.on("focus", function() {
  TAP_ID_LIST.fadeIn();
});

TAP_ID_LIST.on("click", ".tapid", function() {
  id_tap.val($(this).text());
  TAP_ID_LIST.fadeOut();
});

SAVE_TAP.unbind().on("click", function() {
  showLoading(true);

  fetchData("target/update_tap_id_", "POST", { id: id_target_tap.val(), tap_id: id_tap.val() })
    .then(function(response) {
      if (response.success) {
        SwalFireSuccess();
        refreshDataTables(TABLE_TARGET);
        MODAL_DIV_TARGET_TAP.modal("hide");
      }
    })
    .finally(function() {
      showLoading(true);
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
    "val-jenis_kelamin": jenis_kelamin.filter(":checked").val(),
    "val-provinsi": provinsi.val(),
    "val-kabkot": kabkot.val(),
    "val-kecamatan": kecamatan.val(),
    "val-kelurahan": kelurahan.val(),
    "val-alamat": alamat.val()
  }

  if (options && options.type === "update") data["val-id"] = options.id;

  fetchData(ACTION_TARGET.attr("action"), "POST", { ...data })
    .then(function(response) {
      if (response.success) {
        SwalFireSuccess();
        resetErrors();
        refreshDataTables(TABLE_TARGET);
        MODAL_DIV_TARGET.modal("hide");
      }
    })
    .finally(function() {
      showLoading(false);
    });
}
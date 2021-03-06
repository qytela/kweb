var no_tracking = $("#val-no_tracking");
var no_target = $("#val-no_target");
var mulai_aktif = $("#val-mulai_aktif");
var akhir_aktif = $("#val-akhir_aktif");
var status_target = $("input[name=val-status_target]");
var status_target_a = $("#val-status_target-a");
var status_target_t = $("#val-status_target-t");
var tanggal_status = $("#val-tanggal_status");
var operator = $("#val-operator");

var MODAL_DIV_TRACKING_LABEL = $("#modalDivTrackingLabel");
var MODAL_DIV_TRACKING = $("#modalDivTracking");
var SAVE_TRACKING = $("#save-tracking");
var ACTION_TRACKING = $("#action-tracking");
var TABLE_TRACKING = $("#table-tracking");

reset();

$("#add-item-tracking").on("click", function() {
  no_tracking.val(no_target.val());
  tanggal_status.val(makePeriode().akhir_aktif_);
  resetFields([status_target.filter("checked")]);

  fetchData("tracking/get_operator_", "POST", { prefix: no_target.val() })
    .then(function(response) {
      no_tracking.val(no_target.val());
      mulai_aktif.val(makePeriode().mulai_aktif_);
      akhir_aktif.val(makePeriode().akhir_aktif_);
      operator.val(response.nm_operator).trigger("change");

      MODAL_DIV_TRACKING_LABEL.text("Add Tracking");
      MODAL_DIV_TRACKING.modal("show");
      SAVE_TRACKING.unbind().on("click", function() {
        ACTION_TRACKING.attr("action", "tracking/save_");
        onPostTracking();
      });
    });
});

TABLE_TRACKING.on("click", "#item-edit", function() {
  var id = $(this).attr("data");

  resetFields([status_target.filter("checked")]);

  fetchData("tracking/edit_", "POST", { id })
    .then(function(response) {
      no_tracking.val(response.no_tracking);
      mulai_aktif.val(makePeriode(response.mulai_aktif, 1).mulai_aktif_);
      akhir_aktif.val(makePeriode(response.akhir_aktif, 1).akhir_aktif_);
      operator.val(response.operator).trigger("change");

      if (response.status_target === "aktif") {
        status_target_a.prop("checked", true);
      } else {
        status_target_t.prop("checked", true);
      }

      tanggal_status.val(makeDateStatus(response.tanggal_status));

      MODAL_DIV_TRACKING_LABEL.text("Update Tracking");
      MODAL_DIV_TRACKING.modal("show");
      SAVE_TRACKING.unbind().on("click", function() {
        ACTION_TRACKING.attr("action", "tracking/update_");
        onPostTracking({ type: "update", id: response.tracking_id });
      });
    });
});

TABLE_TRACKING.on("click", "#item-delete", function() {
  var id = $(this).attr("data");

  SwalFireDelete({ title: "Anda Yakin?", text: "Hapus data Tracking!" })
    .then(function(result) {
      if (result.isConfirmed) {
        fetchData("tracking/delete_", "POST", { id })
          .then(function(response) {
            if (response.success) {
              SwalFireSuccess();
              refreshDataTables(TABLE_TRACKING);
              refreshDataTables(TABLE_TARGET);
            }
          });
      }
    });
});

akhir_aktif.on("change", function() {
  if (status_target_a.is(":checked")) {
    tanggal_status.val(akhir_aktif.val());
  } else {
    tanggal_status.val(moment().format("DD-MM-YYYY"));
  }
});

status_target.on("change", function() {
  if ($(this).val() === "aktif") {
    tanggal_status.val(akhir_aktif.val());
  } else {
    tanggal_status.val(moment().format("DD-MM-YYYY"));
  }
});

function onPostTracking(options) {
  var data = {
    "val-no_tracking": no_tracking.val(),
    "val-mulai_aktif": mulai_aktif.val(),
    "val-akhir_aktif": akhir_aktif.val(),
    "val-status_target": status_target.filter(":checked").val(),
    "val-tanggal_status": tanggal_status.val(),
    "val-operator": operator.val(),
    "val-id_target_tracking": $("#val-id_target").val()
  }

  if (options && options.type === "update") data["val-id"] = options.id;

  showLoading(true);

  fetchData(ACTION_TRACKING.attr("action"), "POST", { ...data })
    .then(function(response) {
      if (response.success) {
        SwalFireSuccess();
        resetErrors();
        refreshDataTables(TABLE_TRACKING);
        refreshDataTables(TABLE_TARGET);
        MODAL_DIV_TRACKING.modal("hide");
      }
    })
    .finally(function() {
      showLoading(false);
    });
}

function makePeriode(date = new Date(), addMonth = 2) {
  var mulai_aktif__ = new Date(date);
  var mulai_aktif_ = ("0" + mulai_aktif__.getDate()).slice(-2) + "-" + ("0" + (mulai_aktif__.getMonth() + 1)).slice(-2) + "-" + mulai_aktif__.getFullYear();
  var akhir_aktif__ = new Date(date);
  var akhir_aktif_ = ("0" + akhir_aktif__.getDate()).slice(-2) + "-" + ("0" + (akhir_aktif__.getMonth() + addMonth)).slice(-2) + "-" + akhir_aktif__.getFullYear();

  return { mulai_aktif_, akhir_aktif_ };
}

function makeDateStatus(date = new Date()) {
  var tanggal_status_ = new Date(date);
  var tanggal_status = ("0" + tanggal_status_.getDate()).slice(-2) + "-" + ("0" + (tanggal_status_.getMonth() + 1)).slice(-2) + "-" + tanggal_status_.getFullYear();

  return tanggal_status;
}

function reset() {
  mulai_aktif.datepicker("setDate", moment().format("DD-MM-YYYY"));
  akhir_aktif.datepicker("setDate", moment().add("1", "M").format("DD-MM-YYYY"));
}
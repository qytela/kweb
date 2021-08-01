var errors = [];
var ERRORS_CONTANINER = $("#errors");

function fetchData(url, type = "GET", data = {}, headers = {}) {
  return new Promise(function(resolve) {
    $.ajax({
      data, type, headers,
      url: base_url + url,
      dataType: "json",
      success: resolve,
      error: console.error
    });
  });
}

function SwalFireDelete({ title, text }) {
  return new Promise(function(resolve) {
    var swal = Swal.fire({
      title, text,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    });
    resolve(swal);
  });
}

function SwalFireRestore({ title, text }) {
  return new Promise(function(resolve) {
    var swal = Swal.fire({
      title, text,
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, recover it!"
    });
    resolve(swal);
  });
}

function SwalFireSuccess() {
  return new Promise(function(resolve) {
    var swal = Swal.fire({
      title: "Berhasil",
      icon: "success",
      timer: 1500
    });
    resolve(swal);
  });
}

function makeRowCallback() {
  return $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
    return {
      "iStart": oSettings._iDisplayStart,
      "iEnd": oSettings.fnDisplayEnd(),
      "iLength": oSettings._iDisplayLength,
      "iTotal": oSettings.fnRecordsTotal(),
      "iFilteredTotal": oSettings.fnRecordsDisplay(),
      "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
      "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
    };
  };
}

function refreshDataTables(element, fromView = false) {
  if (fromView) return $(`#${element}`).DataTable().ajax.reload();
  element.DataTable().ajax.reload();
}

function resetFields(fields) {
  fields.map(function(item) {
    $(item).val("").trigger("change");
  });
}

function resetSelect(fields) {
  fields.map(function(item) {
    $(item).find("option").remove();
    $(item).append(new Option("", ""));
  });
}

function showHideFields(fields, type) {
  fields.map(function(item) {
    $(item)[type]();
  });
}

function resetErrors() {
  errors = [];
  ERRORS_CONTANINER.html("");
}

function showErrors(msg) {
  return ERRORS_CONTANINER.append(`<div class="alert alert-danger">${msg}</div>`);
}

function showLoading(boolean) {
  if (boolean) {
    $("#submit-action").addClass("d-none");
    $("#loading-action").removeClass("d-none");
  } else {
    $("#submit-action").removeClass("d-none");
    $("#loading-action").addClass("d-none");
  }
}
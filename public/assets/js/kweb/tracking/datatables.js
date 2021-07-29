$.fn.dataTable.ext.errMode = "none";

makeRowCallback();

$("#table-tracking").DataTable({
  oLanguage: {
    sProcessing: "loading..."
  },
  ajax: {
    "url": base_url + "tracking/list_",
    "type": "POST",
    "data": function(data) {
      data.id_target = $("#val-id_target").val();
    }
  },
  processing: true,
  serverSide: true,
  tableReload: true,
  columns: [
    {
      "data": "tipe_tracking",
      "orderable": false,
      className: 'dt-body-center'
    },
    {
      "data": "tipe_tracking"
    },
    {
      "data": "no_tracking"
    },
    {
      "data": "mulai_aktif"
    },
    {
      "data": "akhir_aktif"
    },
    {
      "data": "status_target"
    },
    {
      "data": "operator"
    },
    {
      "data": "view",
      "orderable": false
    }
  ],
  order: [
    [1, 'asc']
  ],
  rowCallback: function(row, data, iDisplayIndex) {
    var info = this.fnPagingInfo();
    var page = info.iPage;
    var length = info.iLength;
    var index = page * length + (iDisplayIndex + 1);
    $('td:eq(0)', row).html(index);
  }
});
$.fn.dataTable.ext.errMode = "none";

makeRowCallback();

$("#table-user").DataTable({
  oLanguage: {
    sProcessing: "loading..."
  },
  ajax: {
    "url": base_url + "user/list_",
    "type": "POST"
  },
  processing: true,
  serverSide: true,
  tableReload: true,
  columns: [
    {
      "data": "nama",
      "orderable": false,
      className: 'dt-body-center'
    },
    {
      "data": "nama"
    },
    {
      "data": "role"
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
makeRowCallback();

$("#table-menu").DataTable({
  oLanguage: {
    sProcessing: "loading..."
  },
  ajax: {
    "url": base_url + "menu/list_",
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
      "data": "icon"
    },
    {
      "data": "label"
    },
    {
      "data": "url"
    },
    {
      "data": "urutan"
    },
    {
      "data": "view",
      "orderable": false
    }
  ],
  order: [
    [5, 'asc']
  ],
  rowCallback: function(row, data, iDisplayIndex) {
    var info = this.fnPagingInfo();
    var page = info.iPage;
    var length = info.iLength;
    var index = page * length + (iDisplayIndex + 1);
    $('td:eq(0)', row).html(index);
  }
});
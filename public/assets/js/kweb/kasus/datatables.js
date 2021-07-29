makeRowCallback();

var options = {
  oLanguage: {
    sProcessing: "loading..."
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
      "data": "keterangan"
    },
    {
      "data": "created_by"
    },
    {
      "data": "created_at"
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
}

$("#table-kasus").DataTable({
  ...options,
  ajax: {
    "url": base_url + "kasus/list_",
    "type": "POST"
  },
});

$("#table-kasus-recycle").DataTable({
  ...options,
  ajax: {
    "url": base_url + "kasus/list_recycle_",
    "type": "POST"
  },
});
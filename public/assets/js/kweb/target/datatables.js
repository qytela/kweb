makeRowCallback();

var TRACKING_LIST = $(".tracking-list");
TRACKING_LIST.hide();

$("#table-target").DataTable({
  oLanguage: {
    sProcessing: "loading..."
  },
  processing: true,
  serverSide: true,
  tableReload: true,
  ajax: {
    "url": base_url + "target/list_",
    "type": "POST",
    "data": function(data) {
      data.id = $('select[id="val-id_kasus"] option').filter(":selected").val();
    }
  },
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
      "data": "no_telp"
    },
    {
      "data": "kasus"
    },
    {
      "data": "tanggal_mulai_aktif"
    },
    {
      "data": "tanggal_akhir_aktif"
    },
    {
      "data": "tanggal_status"
    },
    {
      "data": "tmp_status_target"
    },
    {
      "data": "tap_id",
      className: 'dt-body-center',
      "visible": auth == 'admin tap id' || auth == 'super admin' ? true : false
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

$("#table-target-recycle").DataTable({
  oLanguage: {
    sProcessing: "loading..."
  },
  processing: true,
  serverSide: true,
  tableReload: true,
  ajax: {
    "url": base_url + "target/list_recycle_",
    "type": "POST",
    "data": function(data) {
      data.id = $('select[id="val-id_kasus-recycle"] option').filter(":selected").val();
    }
  },
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
      "data": "no_telp"
    },
    {
      "data": "kasus"
    },
    {
      "data": "provinsi"
    },
    {
      "data": "kabkot"
    },
    {
      "data": "kecamatan"
    },
    {
      "data": "kelurahan"
    },
    {
      "data": "alamat"
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

$("#table-target tbody").on("click", "td", function() {
  var scroll = $(document).height();
  var table = $("#table-target").dataTable();
  var cek = $('#table-target thead tr th').eq($(this).index()).html().trim();
  var iPos = table.fnGetPosition(this.parentElement);
  var data = table.fnGetData(iPos);

  if (auth == 'admin tap id' || auth == 'super admin') {
    if (cek != 'Action' && cek != 'Tap ID') {
      if ($(this.parentElement).hasClass('selected')) {
        $(this.parentElement).removeClass('selected');
        TRACKING_LIST.hide();
      } else {
        table.$('tr.selected').removeClass('selected');
        $(this.parentElement).addClass('selected');
        TRACKING_LIST.show();
        $("#val-id_target").val(data.id);
        $("#table-tracking").DataTable().ajax.reload();

        $("html, body").animate({
          scrollTop: scroll
        }, 1000);
      }
    }
  }
});
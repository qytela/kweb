var tap_id = [];
var tanggal_status = [];
var event_type_id = [];
var params = {};

setParams();
reset();

$(".datepicker").datepicker({
  autoclose: true,
  language: "id",
  format: "dd-mm-yyyy"
});

$("#table-tree").DataTable({
  oLanguage: {
      sProcessing: "loading..."
  },
  processing: true,
  serverSide: true,
  tableReload: true,
  ajax: {
      "url": base_url + "tree/list_",
      "type": "POST",
      "data": function(d) {
          d.tap_id = params.tap_id;
          d.event_type_id = params.event_type_id;
          d.periodstart = params.periodstart;
          d.periodend = params.periodend;
          d.tanggal_status = params.tanggal_status;
      }
  },
  columns: [{
          "data": "no",
          "orderable": false,
          className: 'dt-body-center',
          "width": "4%"
      },
      {
          "data": "EVENT_ID",
          visible: false
      },
      {
          "data": "NAMA_KASUS",
          "orderable": false,
          "searchable": false,
          "width": "10%"
      },
      {
          "data": "NAMA_TARGET",
          "orderable": false,
          "searchable": false,
          "width": "10%"
      },
      {
          "data": "ANUMBER",
          "width": "6.5%"
      },
      {
          "data": "DIRECTION",
          className: 'dt-body-center',
          "width": "5%"
      },
      {
          "data": "BNUMBER",
          "width": "6.5%"
      },
      {
          "data": "STARTTIME",
          render: function(data) {
              return moment(data).format('DD-MM-YYYY HH:mm:ss');
          },
          className: 'dt-body-center',
          "width": "10%"
      },
      {
          "data": "ENDTIME",
          render: function(data) {
              return moment(data).format('DD-MM-YYYY HH:mm:ss');
          },
          className: 'dt-body-center',
          "width": "10%"
      },
      {
          "data": "EVENT_TYPE",
          className: 'dt-body-center',
          "width": "7%"
      },
      {
          "data": "DATASIZE",
          "width": "6%"
      },
      {
          "data": "DURATION",
          render: function(s) {
              function pad(n, z) {
                  z = z || 2;
                  return ('00' + n).slice(-z);
              }

              var ms = s % 1000;
              s = (s - ms) / 1000;
              var secs = s % 60;
              s = (s - secs) / 60;
              var mins = s % 60;
              var hrs = (s - mins) / 60;

              return pad(hrs) + '.' + pad(mins) + '.' + pad(secs);
              // return new Date(data * 1000).toISOString().substr(11, 8);
          },
          className: 'dt-body-center',
          "width": "5%"
      },
      {
          "data": null,
          render: function(data, type, row) {
              let prev = data.PREVIEW;
              let result = '';
              if (data.EVENT_TYPE == 'sms') {
                  if (prev && prev.length >= 50) {
                      const cut_prev = prev.substring(0, 50);
                      let title = "SMS Detail <a href='#' class='close' data-dismiss='alert'>&times;</a>"
                      result = '<a href="javascript:void(0)" class="text-primary" data-html="true" title="' + title + '" data-toggle="popover" data-content="' + data.PREVIEW + '">' + cut_prev + ' ...</a>';
                  } else {
                      result = prev;
                  }
              } else {
                  let content = "";
                  content += "<div class='loading-play'>";
                  content += "<div id='loading_run_" + data.EVENT_ID + "'>";
                  content += "<img src='<?php echo base_url() ?>assets/images/loader-play.gif' width='70%' alt=''>";
                  content += "</div>";
                  content += "<div id='loading_success_" + data.EVENT_ID + "'>";
                  content += "</div>";
                  content += "<div id='loading_failed_" + data.EVENT_ID + "'>";
                  content += " <h2 class'text-primary'>Load file gagal..</h2>";
                  content += "</div>";
                  content += "</div>";
                  let title = "Play Audio <a href='#' class='close' data-dismiss='alert'>&times;</a>"
                  result = '<button type="button" data-html="true" title="' + title + '" data-toggle="popover" data-content="' + content + '" data="' + data.EVENT_ID + '" class="btn btn-primary btn-xs item-play"><span class="btn-icon-left text-primary"><i class="fas fa-play-circle fa-lg"></i> </span>Play</button>';
              }
              return result;
          },
          className: 'dt-body-center',
          "orderable": false,
          "searchable": false,
          "width": "20%"
      }
  ],
  "fnDrawCallback": function(oSettings) {
      $('[data-toggle="popover"]').popover({
          html: true,
      });
      $(document).on("click", ".popover .close", function() {
          $(this).parents(".popover").popover('hide');
      });
  },
  order: [
      [1, 'desc']
  ]
});

$("#filter").on("click", function() {
  if (tree.length == 0) {
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'Pilih filter!',
    });
  } else {
    setParams();
    $('#table-tree').DataTable().ajax.reload();
  }
});

function setTree() {
  var Source = [{
    title: "Kasus",
    folder: true,
    children: setKasus(),
    checkbox: false
  }];

  $("#tree").fancytree({
    checkbox: true,
    source: Source,
    lazyLoad: function(event, data) {
        var node = data.node;
        data.result = setTarget(node.key);
    },
    selectMode: 2,
    select: function(event, data) {
      // Display list of selected nodes
      var selNodes = data.tree.getSelectedNodes();
      // convert to title/key array
      var selKeys = $.map(selNodes, function(node) {
        return parseInt(node.key);
      });
      tap_id = selKeys;
      var selTitles = $.map(selNodes, function(node) {
        return node.title;
      });
      var selTanggalStatus = $.map(selNodes, function(node) {
        return node.data.tanggal_status;
      });
      tanggal_status = selTanggalStatus;
  
      let $ul = $('.selected');
      $ul.html('');
      $ul.append(
        selTitles.map(title =>
          $("<li>").html(title)
        )
      );
    },
  });
  $(".fancytree-container").addClass("fancytree-connectors");
  $(".fancytree-container").css("font-size", "12pt");
}

function setKasus() {
  var data = [];
  $.ajax({
    url: base_url + "tree/get_kasus_",
    type: "POST",
    dataType: "json",
    async: false,
    dataType: "json",
    success: function(response) {
      var object = {}
      $.each(response, function(key, value) {
        object = {
          key: value.id,
          title: value.nama,
          lazy: true,
          checkbox: false,
          folder: true,
        };
        data.push(object);
      });
    },
    error: function() {
      alert("Could not add data");
    }
  });
  return data;
}

function setTarget(id) {
  var data = [];
  $.ajax({
    url: base_url + "tree/get_target_",
    type: "POST",
    data: { id },
    dataType: "json",
    async: false,
    dataType: "json",
    success: function(response) {
      var object = {}
      $.each(response, function(key, value) {
        object = {
          key: value.tap_id,
          title: value.nama,
          mode: "children",
          parent: id,
          checkbox: true,
          tanggal_status: value.tanggal_status
        };
        data.push(object);
      });
    },
    error: function() {
      alert("Could not add data");
    }
  });
  return data;
}

function setParams() {
  params = {
    tap_id: tap_id,
    event_type_id: event_type_id.toString(),
    periodstart: $('#date_awal').val(),
    periodend: $('#date_akhir').val(),
    tanggal_status: tanggal_status
  };
}

function reset() {
  setTree();
  $('#date_awal').datepicker("setDate", moment().add(-3, 'months').format("DD-MM-YYYY"));
  $('#date_akhir').datepicker("setDate", moment().format("DD-MM-YYYY"));
  $('.selected').html('');
  $('#cb_voice').prop('checked', true);
  $('#cb_sms').prop('checked', true);
  // setEventType();
}
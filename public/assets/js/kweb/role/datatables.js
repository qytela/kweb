makeRowCallback();
makeCheckboxMenu();

var PERMISSION_LIST = $("#permission-list");
PERMISSION_LIST.hide();

$("#table-role").DataTable({
  oLanguage: {
    sProcessing: "loading..."
  },
  ajax: {
    "url": base_url + "role/list_",
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

$("#table-role tbody").on("click", "td", function() {
  var scroll = $(document).height();
  var table = $("#table-role").dataTable();
  var cek = $('#table-role thead tr th').eq($(this).index()).html().trim();
  var iPos = table.fnGetPosition(this.parentElement);
  var data = table.fnGetData(iPos);

  if (cek != 'Action') {
    if ($(this.parentElement).hasClass('selected')) {
      $(this.parentElement).removeClass('selected');
      PERMISSION_LIST.hide();
    } else {
      onGetPermission(data.id);
      PERMISSION_LIST.show();
      SAVE_ROLE_PERMISSION.attr("id_state", data.id);
      table.$('tr.selected').removeClass('selected');
      $(this.parentElement).addClass('selected');

      $("html, body").animate({
        scrollTop: scroll
      }, 1000);
    }
  }
});

function onGetPermission(id) {
  fetchData("role/get_role_menu_", "POST", { id })
    .then(function(data) {
      $('input[name="check_menus"]').each(function() {
        this.checked = false;
      });
      if (data.length > 0) {
        data.forEach(function(role_menu, i) {
          $('#menu_' + role_menu.id_menu).prop('checked', true);
        });
      } else {
        $('input[name="check_menus"]').each(function() {
          this.checked = false;
        });
      }
    });
}

function makeCheckboxMenu() {
  fetchData("role/get_menus_", "POST")
    .then(function(data) {
      var checkboxmenus = "";
      var i;
      for (i = 0; i < data.length; i++) {
        checkboxmenus += `<div class="form-check mb-3">`;
        checkboxmenus += `<input class="form-check-input" type="checkbox" name="check_menus" id="menu_${data[i].id}" value="${data[i].id}">`;
        checkboxmenus += `<label class="form-check-label ml-1" style="font-size: 18px;">${data[i].label}</label>`
        checkboxmenus += `</div>`;
      }
      $('#table-role-permission').html(checkboxmenus);
    });
}
var PROVINSI = $("#val-provinsi");
var KABKOT = $("#val-kabkot");
var KECAMATAN = $("#val-kecamatan");
var KELURAHAN = $("#val-kelurahan");

fetchData("tracking/get_provinsi_", "POST")
  .then(function(response) {
    response.map(function(item) {
      PROVINSI.append(new Option(item.nama, item.id));
    });
  });

PROVINSI.on("change", function() {
  resetSelect([KABKOT, KECAMATAN, KELURAHAN]);
  getKabKot($(this).val());
});

KABKOT.on("change", function() {
  resetSelect([KECAMATAN, KELURAHAN]);
  getKecamatan($(this).val());
});

KECAMATAN.on("change", function() {
  resetSelect([KELURAHAN]);
  getKelurahan($(this).val());
});

function getKabKot(id) {
  fetchData("tracking/get_kabkot_", "POST", { id })
    .then(function(response) {
      response.map(function(item) {
        KABKOT.append(new Option(item.nama, item.id));
      });
    });
}

function getKecamatan(id) {
  fetchData("tracking/get_kecamatan_", "POST", { id })
    .then(function(response) {
      response.map(function(item) {
        KECAMATAN.append(new Option(item.nama, item.id));
      });
    });
}

function getKelurahan(id) {
  fetchData("tracking/get_kelurahan_", "POST", { id })
    .then(function(response) {
      response.map(function(item) {
        KELURAHAN.append(new Option(item.nama, item.id));
      });
    });
}
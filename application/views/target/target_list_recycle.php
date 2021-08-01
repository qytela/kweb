<div class="row">
  <div class="col-6">
    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <h4 class="title">Kasus</h4>
        </div>
        <select class="form-control select2" name="val-id_kasus-recycle" id="val-id_kasus-recycle">
          <option value="">Pilih semua kasus</option>
          <?php foreach ($kasus_data as $row) : ?>
            <option value="<?= $row->id; ?>"><?= $row->nama; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4>Target List Recycle</h4>
        <div>
          <a href="<?= base_url() ?>target" class="btn btn-rounded btn-info mr-2">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-target-recycle" style="width: 100%;">
            <thead>
              <tr>
                <tr>
                  <th width="50px">No</th>
                  <th>Nama</th>
                  <th>No Telpon</th>
                  <th>Kasus</th>
                  <th>Provinsi</th>
                  <th>Kabupaten/Kota</th>
                  <th>Kecamatan</th>
                  <th>Kelurahan</th>
                  <th>Alamat</th>
                  <th>Action</th>
                </tr>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

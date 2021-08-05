<div class="row">
  <div class="col-12 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <h4 class="title">Kasus</h4>
        </div>
        <select class="form-control select2" name="val-id_kasus" id="val-id_kasus">
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
        <h4>Target List</h4>
        <div>
          <button class="btn btn-rounded btn-info mr-2" id="add-item-target">Add Target</button>
          <button class="btn btn-rounded btn-success mr-2" onclick="refreshDataTables('table-target', true)">Refresh</button>
          <a href="<?= base_url() ?>target/recycle" class="btn btn-rounded btn-danger mt-2 mt-md-0">Recycle</a>
        </div>
      </div>
      <div class="card-body">
        <h4 style="font-style: italic;color: #283593; font-size: 12px;"><span class="text-danger">*</span>note : klik dibaris target untuk mengaktifkan</h4>
        <div class="table-responsive">
          <table class="table table-striped costum-table" id="table-target">
            <thead>
              <tr>
                <th width="50px">No</th>
                <th>Nama</th>
                <th>No Telpon</th>
                <th>Kasus</th>
                <th>Periode Mulai Aktif</th>
                <th>Periode Akhir Aktif</th>
                <th>Tanggal Status</th>
                <th>Status</th>
                <th>Tap ID</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('tracking/tracking_list'); ?>
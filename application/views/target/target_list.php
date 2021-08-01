<div class="row">
  <div class="col-6">
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
          <btn class="btn btn-rounded btn-info mr-2" id="add-item-target">Add Target</btn>
          <btn class="btn btn-rounded btn-success mr-2">Refresh</btn>
          <a href="<?= base_url() ?>target/recycle" class="btn btn-rounded btn-danger">Recycle</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-target" style="width: 100%;">
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
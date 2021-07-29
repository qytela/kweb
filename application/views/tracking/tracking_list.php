<div class="row tracking-list">
  <input type="hidden" id="val-id_target" value="">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4>Tracking List</h4>
        <div>
          <btn class="btn btn-rounded btn-info mr-2" id="add-item-tracking">Add Tracking</btn>
          <btn class="btn btn-rounded btn-success mr-2">Refresh</btn>
          <a href="<?= base_url() ?>kasus/recycle" class="btn btn-rounded btn-danger">Recycle</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-tracking" style="width: 100%;">
            <thead>
              <tr>
                <th width="50px">No</th>
                <th>Tipe Tracking</th>
                <th>No Tracking</th>
                <th>Periode Mulai Aktif</th>
                <th>Periode Akhir Aktif</th>
                <th>Status Target</th>
                <th>Operator</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
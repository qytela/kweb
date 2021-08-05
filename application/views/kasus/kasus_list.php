<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4>Kasus List</h4>
        <div>
          <button class="btn btn-rounded btn-info mr-2" id="add-item-kasus">Add Kasus</button>
          <button class="btn btn-rounded btn-success mr-2" onclick="refreshDataTables('table-kasus', true)">Refresh</button>
          <a href="<?= base_url() ?>kasus/recycle" class="btn btn-rounded btn-danger mt-2 mt-md-0">Recycle</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped costum-table" id="table-kasus">
            <thead>
              <tr>
                <th width="50px">No</th>
                <th>Kasus</th>
                <th>Keterangan</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
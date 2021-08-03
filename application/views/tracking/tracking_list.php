<div class="row tracking-list">
  <input type="hidden" id="val-id_target" value="">
  <input type="hidden" id="val-no_target" value="">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4>Tracking List</h4>
        <div>
          <btn class="btn btn-rounded btn-info mr-2" id="add-item-tracking">Add Tracking</btn>
          <btn class="btn btn-rounded btn-success mr-2" onclick="refreshDataTables('table-tracking', true)">Refresh</btn>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped costum-table" id="table-tracking">
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
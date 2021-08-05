<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4>Menu List</h4>
        <div>
          <button class="btn btn-rounded btn-info mr-2" id="add-item-menu">Add Menu</button>
          <button class="btn btn-rounded btn-success mr-2" onclick="refreshDataTables('table-menu', true)">Refresh</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped costum-table" id="table-menu">
            <thead>
              <tr>
                <th width="50px">No</th>
                <th>Menu</th>
                <th>Icon</th>
                <th>Label</th>
                <th>URL</th>
                <th>Urutan</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
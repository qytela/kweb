<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4>User List</h4>
        <div>
          <button class="btn btn-rounded btn-info mr-2" id="add-item-user">Add User</button>
          <button class="btn btn-rounded btn-success mr-2" onclick="refreshDataTables('table-user', true)">Refresh</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped costum-table" id="table-user">
            <thead>
              <tr>
                <th width="50px">No</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
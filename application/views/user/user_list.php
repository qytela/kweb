<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4>User List</h4>
        <div>
          <btn class="btn btn-rounded btn-info mr-2" id="add-item-user">Add User</btn>
          <btn class="btn btn-rounded btn-success mr-2" onclick="refreshDataTables('table-user', true)">Refresh</btn>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-user" style="width: 100%;">
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
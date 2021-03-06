<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h4>Role List</h4>
        <div>
          <button class="btn btn-rounded btn-info mr-2" id="add-item-role">Add Role</button>
          <button class="btn btn-rounded btn-success mr-2" onclick="refreshDataTables('table-role', true)">Refresh</button>
        </div>
      </div>
      <div class="card-body">
        <h4 style="font-style: italic;color: #283593; font-size: 12px;"><span class="text-danger">*</span>note : klik baris target untuk menambahkan menu permission</h4>
        <div class="table-responsive">
          <table class="table table-striped costum-table" id="table-role">
            <thead>
              <tr>
                <th width="50px">No</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row" id="permission-list">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <h4 class="title">Role Menu Permission</h4>
        </div>
        <div id="table-role-permission"></div>
        <div id="submit-action">
          <button type="submit" class="btn btn-primary" id="save-role-permission">Save</button>
        </div>
        <div id="loading-action" class="d-none">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
  </div>
</div>
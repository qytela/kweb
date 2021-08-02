<div class="modal fade" id="modalDivPassword" role="dialog" data-backdrop="static" aria-labelledby="modalDivPasswordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDivPasswordLabel">Update Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="errors-password"></div>
        <form id="action-role">
          <div class="form-group" id="nama">
            <label>Password Lama <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Masukkan password lama" name="val-password_" id="val-password_">
            </div>
          </div>
          <div class="form-group" id="nama">
            <label>Password Baru <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Masukkan password baru..." name="val-password_update" id="val-password_update">
            </div>
          </div>
          <div class="form-group" id="nama">
            <label>Konfimasi Password Baru <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Konfirmasi password baru..." name="val-password_update_2" id="val-password_update_2">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" style="background-color: #f7f9f9 !important;">
        <div id="submit-password">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="save-password">Save</button>
        </div>
        <div id="loading-password" class="d-none">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
  </div>
</div>

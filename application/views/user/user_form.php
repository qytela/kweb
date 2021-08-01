<div class="modal fade" id="modalDivUser" role="dialog" data-backdrop="static" aria-labelledby="modalDivUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDivUserLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="errors"></div>
        <form id="action-user">
          <div class="form-group" id="nama">
            <label>Nama <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan Nama..." name="val-nama" id="val-nama">
            </div>
          </div>
          <div class="form-group" id="username">
            <label>Username <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan Username..." name="val-username" id="val-username">
            </div>
          </div>
          <div class="form-group" id="password">
            <label>Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Masukkan Password..." name="val-password" id="val-password">
            </div>
          </div>
          <div class="form-group" id="password-confirm">
            <label>Confirm Password <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="Masukkan Konfirmasi Password..." name="val-password_confirm" id="val-password_confirm">
            </div>
          </div>
          <div class="form-group" id="role">
            <label>Hak Akses <span class="text-danger">*</span></label>
            <div class="input-group">
              <select class="form-control select2" name="val-id_role" id="val-id_role" data-placeholder="--Pilih Hak Akses--">
                <option value=""></option>
                <?php foreach ($role_data as $row) : ?>
                  <option value="<?= $row->id; ?>"><?= $row->nama; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" style="background-color: #f7f9f9 !important;">
        <div id="submit-action">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="save">Save</button>
        </div>
        <div id="loading-action" class="d-none">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
  </div>
</div>

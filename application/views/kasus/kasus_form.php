<div class="modal fade" id="modalDivKasus" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modalDivKasusLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDivKasusLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="errors"></div>
        <form id="action-kasus">
          <div class="form-group">
          <label>Kasus <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan nama kasus..." name="val-nama" id="val-nama">
            </div>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <div class="input-group">
              <textarea class="form-control" placeholder="Masukkan keterangan..." name="val-keterangan" id="val-keterangan" rows="5" style="height: 100px;"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label>Users <span class="text-danger">*</span></label>
            <div class="input-group">
              <select class="form-control select2" multiple="multiple" name="val-users[]" id="val-users" data-placeholder="--Pilih Users--">
                <?php foreach ($users_data as $row) : ?>
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

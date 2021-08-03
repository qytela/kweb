<div class="modal fade" id="modalDivTracking" role="dialog" data-backdrop="static" aria-labelledby="modalDivTrackingLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDivTrackingLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="errors"></div>
        <form id="action-tracking">
          <div class="form-group">
            <label>No Tracking</label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan No Tracking..." name="val-no_tracking" id="val-no_tracking" readonly>
            </div>
          </div>
          <div class="form-group">
            <label>Operator</label>
            <div class="input-group">
              <select class="form-control select2" name="val-operator" id="val-operator" data-placeholder="Pilih Operator">
                <option value="TELKOMSEL">TELKOMSEL</option>
                <option value="XL">XL</option>
                <option value="SMARTFREN">SMARTFREN</option>
                <option value="INDOSAT">INDOSAT</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Periode Mulai Aktif</label>
            <div class="input-group">
              <input type="text" class="form-control inputmask" placeholder="Masukkan Periode Mulai Aktif..." name="val-mulai_aktif" id="val-mulai_aktif" data-mask="99-99-9999">
            </div>
          </div>
          <div class="form-group">
            <label>Periode Akhir Aktif</label>
            <div class="input-group">
              <input type="text" class="form-control inputmask" placeholder="Masukkan Periode Akhir Aktif..." name="val-akhir_aktif" id="val-akhir_aktif" data-mask="99-99-9999">
            </div>
          </div>
          <div class="form-group">
            <label>Aktif/Tidak Aktif</label>
            <div class="row">
              <div class="col-6">
                <div class="form-check">
                  <input type="radio" class="form-check-input" name="val-status_target" id="val-status_target-a" value="aktif" checked>
                  <label class="form-check-label">
                    Aktif
                  </label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-check">
                  <input type="radio" class="form-check-input" name="val-status_target" id="val-status_target-t" value="tidak aktif">
                  <label class="form-check-label">
                    Tidak Aktif
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Tanggal Status</label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan Tanggal Status..." name="val-tanggal_status" id="val-tanggal_status" readonly>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" style="background-color: #f7f9f9 !important;">
        <div id="submit-action">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="save-tracking">Save</button>
        </div>
        <div id="loading-action" class="d-none">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
  </div>
</div>

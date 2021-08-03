<div class="modal fade" id="modalDivTargetTap" role="dialog" data-backdrop="static" aria-labelledby="modalDivTargetTapLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDivTargetTapLabel">Add Tap ID</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="errors"></div>
        <form id="action-target-tap">
          <div class="form-group">
            <label>Tap ID</label>
            <div class="input-group">
              <input type="number" class="form-control" placeholder="Masukkan Tap ID..." name="val-tap_id" id="val-tap_id">
            </div>
            <div id="tap-id-list"></div>
          </div>
          <input type="hidden" id="val-id_target_tap_id" value="">
        </form>
      </div>
      <div class="modal-footer" style="background-color: #f7f9f9 !important;">
        <div id="submit-action">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="save-tap">Save</button>
        </div>
        <div id="loading-action" class="d-none">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
  </div>
</div>
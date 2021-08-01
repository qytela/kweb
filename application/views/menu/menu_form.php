<div class="modal fade" id="modalDivMenu" role="dialog" data-backdrop="static" aria-labelledby="modalDivMenuLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDivMenuLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="errors"></div>
        <form id="action-menu">
          <div class="form-group" id="nama">
            <label>Menu <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan Menu..." name="val-nama" id="val-nama">
            </div>
          </div>
          <div class="form-group" id="nama">
            <label>Icon <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan Icon..." name="val-icon" id="val-icon">
            </div>
          </div>
          <div class="form-group" id="nama">
            <label>Label <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan Label..." name="val-label" id="val-label">
            </div>
          </div>
          <div class="form-group" id="nama">
            <label>URL <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan URL..." name="val-url" id="val-url">
            </div>
          </div>
          <div class="form-group" id="nama">
            <label>Urutan <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan Urutan..." name="val-urutan" id="val-urutan">
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

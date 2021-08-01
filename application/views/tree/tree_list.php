<div class="row">
  <div class="col-3">
    <div class="card">
      <div class="card-body" id="tree">
        
      </div>
    </div>
  </div>
  <div class="col-9">
    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <h4 class="title">Filter Event List</h4>
        </div>
        <div class="row">
          <div class="col-6">
            <h5 style="color: #000;">Selected:</h5>
            <ol class="selected" style="color: #000; margin-left: -15px;"></ol>
          </div>
          <div class="col-6">
            <div class="row">
              <div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="cb_voice" id="cb_voice" checked>
                  <label class="form-check-label">
                    Voice call (incl. VoIP)
                  </label>
                </div>
                <div class="form-group">
                  <label>Tanggal Awal</label>
                  <input type="text" class="form-control datepicker" name="date_awal" id="date_awal">
                </div>
              </div>
              <div class="ml-3">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="cb_sms" id="cb_sms" checked>
                  <label class="form-check-label">
                    SMS
                  </label>
                </div>
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="text" class="form-control datepicker" name="date_akhir" id="date_akhir">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="submit-action">
          <button type="button" class="btn btn-secondary" onclick="reset()">Reset</button>
          <button type="submit" class="btn btn-primary" id="filter">Filter</button>
        </div>
        <div id="loading-action" class="d-none">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-tree" style="width: 100%;">
            <thead>
              <tr>
                <th>No</th>
                <th>Event ID</th>
                <th>Nama Kasus</th>
                <th>Nama Target</th>
                <th>No. Target</th>
                <th>Direction</th>
                <th>Respondent</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Event Type</th>
                <th>Data Size</th>
                <th>Duration</th>
                <th>Preview/Play</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
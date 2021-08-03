
<div class="row">
  <div class="col-12 col-md-3">
    <div class="card">
      <div class="card-body" id="tree"></div>
    </div>
  </div>
  <div class="col-12 col-md-9">
    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <h4 class="title">Filter Event List</h4>
        </div>
        <div class="row">
          <div class="col-12 col-md-4 col-xl-6">
            <h4 style="color: #000; font-size: 12px;">Selected:</h4>
            <ol class="selected" style="font-size: 10px; color: #000; margin-left: -15px;"></ol>
          </div>
          <div class="col-12 col-md-8 col-xl-6">
            <div class="row" id="cb_event_type">
              <div class="ml-3">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="cb_voice" id="cb_voice" value="10">
                  <label class="form-check-label ml-1">
                    Voice call (incl. VoIP)
                  </label>
                </div>
                <div class="form-group">
                  <label>Tanggal Awal</label>
                  <input type="text" class="datepicker form-control form-control--small date-label" name="date_awal" id="date_awal" data-mask="99-99-9999">
                  <span class="date-label">DD-MM-YYYY</span>
                </div>
              </div>
              <div class="ml-3">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="cb_sms" id="cb_sms" value="3">
                  <label class="form-check-label ml-1">
                    SMS
                  </label>
                </div>
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="text" class="datepicker form-control form-control--small date-label" name="date_akhir" id="date_akhir" data-mask="99-99-9999">
                  <span class="date-label">DD-MM-YYYY</span>
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
          <table class="table table-striped costum-table" id="table-tree">
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
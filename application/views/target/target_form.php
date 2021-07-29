<div class="modal fade" id="modalDivTarget" role="dialog" data-backdrop="static" aria-labelledby="modalDivTargetLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDivTargetLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="errors"></div>
        <form id="action-kasus">
          <div class="form-group">
            <label>Kasus</label>
            <div class="input-group">
              <select class="form-control select2" name="val-id_kasus_target" id="val-id_kasus_target" data-placeholder="Pilih Kasus">
                <option value=""></option>
                <?php foreach ($kasus_data as $row) : ?>
                  <option value="<?= $row->id; ?>"><?= $row->nama; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>NIK</label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan NIK..." name="val-nik" id="val-nik">
            </div>
          </div>
          <div class="form-group">
            <label>No Telpon <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="number" class="form-control" placeholder="Masukkan No Telpon..." name="val-no_telp" id="val-no_telp">
            </div>
          </div>
          <div class="form-group">
            <label>Nama</label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Masukkan Nama..." name="val-nama" id="val-nama">
            </div>
          </div>
          <div class="form-group">
            <label>Tempat/Tanggal Lahir</label>
            <div class="row">
              <div class="col-6">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir..." name="val-tempat_lahir" id="val-tempat_lahir">
                </div>
              </div>
              <div class="col-6">
                <div class="input-group">
                  <input type="date" class="form-control" placeholder="Masukkan Tanggal Lahir..." name="val-tanggal_lahir" id="val-tanggal_lahir">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
            <div class="row">
              <div class="col-6">
                <div class="form-check">
                  <input type="radio" class="form-check-input" name="val-jenis_kelamin" id="val-jenis_kelamin-l" value="1" checked>
                  <label class="form-check-label">
                    Laki-laki
                  </label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-check">
                  <input type="radio" class="form-check-input" name="val-jenis_kelamin" id="val-jenis_kelamin-p" value="0">
                  <label class="form-check-label">
                    Perempuan
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Provinsi</label>
            <div class="input-group">
              <select class="form-control select2" name="val-provinsi" id="val-provinsi" data-placeholder="--Pilih Provinsi--">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Kabupaten/Kota</label>
            <div class="input-group">
              <select class="form-control select2" name="val-kabkot" id="val-kabkot" data-placeholder="--Pilih Kabupaten/Kota--">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Kecamatan</label>
            <div class="input-group">
              <select class="form-control select2" name="val-kecamatan" id="val-kecamatan" data-placeholder="--Pilih Kecamatan--">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Kelurahan</label>
            <div class="input-group">
              <select class="form-control select2" name="val-kelurahan" id="val-kelurahan" data-placeholder="--Pilih Kelurahan--">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <div class="input-group">
              <textarea class="form-control" placeholder="Masukkan Alamat..." name="val-alamat" id="val-alamat" rows="5" style="height: 100px;"></textarea>
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
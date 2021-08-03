<?php

class Target_model extends CI_Model
{

    function get_all()
    {
        $id_kasus = $this->input->post('id');
        $this->datatables->select("tbl_target.id, tbl_target.nama, to_char(tbl_target.no_telp, '999999999999999') as no_telp, tbl_target.alamat, provinsi.nama as provinsi, kabkot.nama as kabkot, kecamatan.nama as kecamatan, kelurahan.nama as kelurahan, tbl_kasus.nama as kasus, tbl_target.tap_id, (select to_char(mulai_aktif, 'YYYY-MM-DD') from tbl_tracking where tbl_tracking.id_target = tbl_target.id order by tracking_id desc limit 1) as tanggal_mulai_aktif, (select to_char(akhir_aktif, 'YYYY-MM-DD') from tbl_tracking where tbl_tracking.id_target = tbl_target.id order by tracking_id desc limit 1) as tanggal_akhir_aktif, (select to_char(tanggal_status, 'YYYY-MM-DD') from tbl_tracking where tbl_tracking.id_target = tbl_target.id order by tracking_id desc limit 1) as tanggal_status, (select upper(tmp_status_target) from tbl_tracking where tbl_tracking.id_target = tbl_target.id order by tracking_id desc limit 1) as tmp_status_target");
        $this->datatables->from('tbl_target');
        $this->datatables->join('provinsi', 'provinsi.id = tbl_target.provinsi', 'left');
        $this->datatables->join('kabkot', 'kabkot.id = tbl_target.kabkot', 'left');
        $this->datatables->join('kecamatan', 'kecamatan.id = tbl_target.kecamatan', 'left');
        $this->datatables->join('kelurahan', 'kelurahan.id = tbl_target.kelurahan', 'left');
        $this->datatables->join('tbl_kasus', 'tbl_kasus.id = tbl_target.id_kasus', 'left');
        if ($id_kasus != '') {
            $this->datatables->where('id_kasus', $id_kasus);
        } else {
            $this->datatables->where_in('id_kasus', array(14, 15));
        }
        $this->datatables->where('tbl_target.deleted_at', null);
        $this->datatables->add_column('view', '<a href="javascript:void(0);" class="btn btn-success btn-sm" id="item-edit" data="$1">Edit</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="item-delete" data="$1">Delete</a>',
                                              'id, no_telp');
        return $this->datatables->generate();
    }

    function get_recycle()
    {
        $id_kasus = $this->input->post('id');
        $this->datatables->select("tbl_target.id, tbl_target.nama, to_char(tbl_target.no_telp, '999999999999999') as no_telp, tbl_target.alamat,
                                    provinsi.nama as provinsi, kabkot.nama as kabkot, kecamatan.nama as kecamatan, kelurahan.nama as kelurahan,
                                    tbl_kasus.nama as kasus, tbl_target.tap_id");
        $this->datatables->from('tbl_target');
        $this->datatables->join('provinsi', 'provinsi.id = tbl_target.provinsi', 'left');
        $this->datatables->join('kabkot', 'kabkot.id = tbl_target.kabkot', 'left');
        $this->datatables->join('kecamatan', 'kecamatan.id = tbl_target.kecamatan', 'left');
        $this->datatables->join('kelurahan', 'kelurahan.id = tbl_target.kelurahan', 'left');
        $this->datatables->join('tbl_kasus', 'tbl_kasus.id = tbl_target.id_kasus', 'left');
        if ($id_kasus != '') {
            $this->datatables->where('id_kasus', $id_kasus);
        }
        $this->datatables->where('tbl_target.deleted_at is not null', null, false);
        $this->datatables->add_column('view', '<a href="javascript:void(0);" class="btn btn-success btn-sm" id="item-recycle" data="$1">Recover</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="item-delete" data="$1">Delete</a>',
                                              'id');
        return $this->datatables->generate();
    }

    public function save()
    {
        $tanggal_lahir_ = $this->input->post('val-tanggal_lahir', TRUE);
        $tanggal_lahir = date('Y-m-d', strtotime($tanggal_lahir_));
        $field = array(
            'nama' => strtoupper($this->input->post('val-nama', TRUE)),
            'no_telp' => $this->input->post('val-no_telp', TRUE),
            'tempat_lahir' => strtoupper($this->input->post('val-tempat_lahir', TRUE)),
            'tanggal_lahir' => $tanggal_lahir,
            'nik' => $this->input->post('val-nik', TRUE),
            'jenis_kelamin' => $this->input->post('val-jenis_kelamin', TRUE),
            'alamat' => $this->input->post('val-alamat', TRUE),
            'kelurahan' => $this->input->post('val-kelurahan', TRUE),
            'kecamatan' => $this->input->post('val-kecamatan', TRUE),
            'kabkot' => $this->input->post('val-kabkot', TRUE),
            'provinsi' => $this->input->post('val-provinsi', TRUE),
            'id_kasus' => $this->input->post('val-id_kasus_target', TRUE),

            'created_by' => $this->session->userdata('username')
        );
        $this->db->insert('tbl_target', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_target');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function update()
    {
        date_default_timezone_set("Asia/Bangkok");
        $id = $this->input->post('val-id');
        $tanggal_lahir_ = $this->input->post('val-tanggal_lahir', TRUE);
        $tanggal_lahir = date('Y-m-d', strtotime($tanggal_lahir_));
        $field = array(
            'nama' => strtoupper($this->input->post('val-nama', TRUE)),
            'no_telp' => $this->input->post('val-no_telp', TRUE),
            'tempat_lahir' => strtoupper($this->input->post('val-tempat_lahir', TRUE)),
            'tanggal_lahir' => $tanggal_lahir,
            'nik' => $this->input->post('val-nik', TRUE),
            'jenis_kelamin' => $this->input->post('val-jenis_kelamin', TRUE),
            'alamat' => $this->input->post('val-alamat', TRUE),
            'kelurahan' => $this->input->post('val-kelurahan', TRUE),
            'kecamatan' => $this->input->post('val-kecamatan', TRUE),
            'kabkot' => $this->input->post('val-kabkot', TRUE),
            'provinsi' => $this->input->post('val-provinsi', TRUE),
            'id_kasus' => $this->input->post('val-id_kasus_target', TRUE),

            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date("Y-m-d h:i:sa")
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_target', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('tbl_target');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_soft()
    {
        $id = $this->input->post('id');
        date_default_timezone_set("Asia/Bangkok");
        $field = array(
            'updated_by' => $this->session->userdata('username'),
            'deleted_at' => date("Y-m-d h:i:sa")
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_target', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_all()
    {
        $id_kasus = $this->input->post('id');
        $this->datatables->where('id_kasus', $id_kasus);
        $this->db->where('deleted_at is not null', null, false);
        $this->db->delete('tbl_target');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function restore()
    {
        $id = $this->input->post('id');
        date_default_timezone_set("Asia/Bangkok");
        $field = array(
            'deleted_at' => null
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_target', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function restore_all()
    {
        date_default_timezone_set("Asia/Bangkok");
        $field = array(
            'deleted_at' => null
        );
        $id_kasus = $this->input->post('id');
        $this->datatables->where('id_kasus', $id_kasus);
        $this->db->where('deleted_at is not null', null, false);
        $this->db->update('tbl_target', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_target()
    {
        $id_kasus = $this->input->post('id');
        $this->db->select("tbl_target.*, (SELECT tbl_tracking.tanggal_status FROM tbl_tracking WHERE tbl_tracking.id_target = tbl_target.id order by tracking_id desc limit 1) as tanggal_status");
        $this->db->where('id_kasus', $id_kasus);
        $this->db->where('tbl_target.deleted_at', null);
        $this->db->order_by('tbl_target.nama', 'asc');
        $query = $this->db->get('tbl_target');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_target_by_tap($tap_id)
    {
        $this->db->select('tbl_target.tap_id, tbl_target.nama as nama_target, tbl_kasus.nama as nama_kasus');
        $this->db->join('tbl_kasus', 'tbl_kasus.id = tbl_target.id_kasus', 'left');
        $this->db->where_in('tap_id', $tap_id);
        $this->db->where('tbl_target.deleted_at', null);
        $query = $this->db->get('tbl_target');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function update_tap_id()
    {
        date_default_timezone_set("Asia/Bangkok");
        $id = $this->input->post('id');
        $field = array(
            'tap_id' => trim($this->input->post('tap_id', TRUE)),

            'updated_by' => $this->session->userdata('username'),
            'updated_at' => date("Y-m-d h:i:sa")
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_target', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

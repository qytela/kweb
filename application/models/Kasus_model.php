<?php

class Kasus_model extends CI_Model {
  public function test() {
    return $this->db->get('tbl_kasus')->result_array();
  }

  public function get_all() {
    $status = $this->session->userdata('status');
    $id = $this->session->userdata('id');

    $this->datatables->select("tbl_kasus.id, tbl_kasus.nama, tbl_kasus.keterangan, tbl_kasus.created_by, to_char(tbl_kasus.created_at, 'DD-MM-YYYY HH24:MI'::text) AS created_at");
    $this->datatables->from('tbl_kasus');
    $this->datatables->where('tbl_kasus.deleted_at', null);
    if ($status == 'user') {
      $this->datatables->join('tbl_kasus_user', 'tbl_kasus.id = tbl_kasus_user.id_kasus');
      $this->datatables->join('tbl_user', 'tbl_kasus_user.id_user = tbl_user.id');
      $this->datatables->where('tbl_user.id', $id);
    }
    $this->datatables->add_column('view', '<a href="javascript:void(0);" class="btn btn-success" id="item-edit" data="$1">Edit</a> <a href="javascript:void(0);" class="btn btn-danger" id="item-delete" data="$1">Delete</a>',
                                          'id, no_telp');
    return $this->datatables->generate();
  }

  function get_recycle()
  {
    $status = $this->session->userdata('status');
    $id = $this->session->userdata('id');
    $this->datatables->select("tbl_kasus.id, tbl_kasus.nama, tbl_kasus.keterangan, tbl_kasus.created_by, tbl_kasus.created_at");
    $this->datatables->from('tbl_kasus');
    $this->datatables->where('tbl_kasus.deleted_at is not null', null, false);
    if ($status == 'user') {
      $this->datatables->join('tbl_kasus_user', 'tbl_kasus.id = tbl_kasus_user.id_kasus');
      $this->datatables->join('tbl_user', 'tbl_kasus_user.id_user = tbl_user.id');
      $this->datatables->where('tbl_user.id', $id);
    }
    $this->datatables->add_column('view', '<a href="javascript:void(0);" class="btn btn-success" id="item-recycle" data="$1">Recover</a> <a href="javascript:void(0);" class="btn btn-danger" id="item-delete" data="$1">Delete</a>',
                                          'id');
    return $this->datatables->generate();
  }

    public function save()
    {
      $field = array(
        'nama' => $this->input->post('val-nama', TRUE),
        'keterangan' => $this->input->post('val-keterangan', TRUE),
        'created_by' => $this->session->userdata('username')
      );
      $this->db->insert('tbl_kasus', $field);
      $id = $this->db->insert_id();
      if ($this->db->affected_rows() > 0) {
        $users = $this->input->post('val-users', TRUE);
        if ($users) {
          for ($i = 0; $i < count($users); $i++) {
            $field1 = array(
              'id_kasus' => $id,
              'id_user' => $users[$i]
            );
            $this->db->insert('tbl_kasus_user', $field1);
          }
          if ($this->db->affected_rows() > 0) {
            return true;
          } else {
            return false;
          }
        } else {
          $id_user = $this->session->userdata('id');

          $field2 = array(
            'id_kasus' => $id,
            'id_user' => $id_user
          );
          $this->db->insert('tbl_kasus_user', $field2);
          if ($this->db->affected_rows() > 0) {
            return true;
          } else {
            return false;
          }
        }
      } else {
        return false;
      }
    }

    public function edit()
    {
      $id = $this->input->post('id');
      $this->db->where('id', $id);
      $query = $this->db->get('tbl_kasus');
      $data = $query->row();

      $users = array();
      $this->db->select('id_user');
      $this->db->where('id_kasus', $data->id);
      $query1 = $this->db->get('tbl_kasus_user');
      $users_data = $query1->result_array();
      foreach ($users_data as $user) {
        array_push($users, $user['id_user']);
      }
      $data->users = $users;
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
      $field = array(
        'nama' => $this->input->post('val-nama', TRUE),
        'keterangan' => $this->input->post('val-keterangan', TRUE),
        'updated_by' => $this->session->userdata('username'),
        'updated_at' => date("Y-m-d h:i:sa")
      );
      $this->db->where('id', $id);
      $this->db->update('tbl_kasus', $field);
      if ($this->db->affected_rows() > 0) {
        $status = $this->session->userdata('status');
        if ($status != 'user') {
          $this->db->delete('tbl_kasus_user', array('id_kasus' => $id));
        }
        $users = $this->input->post('val-users', TRUE);
        if ($users) {
          for ($i = 0; $i < count($users); $i++) {
            $field1 = array(
              'id_kasus' => $id,
              'id_user' => $users[$i]
            );
            $this->db->insert('tbl_kasus_user', $field1);
          }
          if ($this->db->affected_rows() > 0) {
            return true;
          } else {
            return false;
          }
        } else {
          return true;
        }
      } else {
        return false;
      }
    }

    function delete()
    {
      $id = $this->input->post('id');
      $this->db->where('id', $id);
      $this->db->delete('tbl_kasus');
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
      $this->db->update('tbl_kasus', $field);
      if ($this->db->affected_rows() > 0) {
        return true;
      } else {
        return false;
      }
    }

    function delete_all()
    {
      $this->db->where('deleted_at is not null', null, false);
      $this->db->delete('tbl_kasus');
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
      $this->db->update('tbl_kasus', $field);
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
      $this->db->where('deleted_at is not null', null, false);
      $this->db->update('tbl_kasus', $field);
      if ($this->db->affected_rows() > 0) {
        return true;
      } else {
        return false;
      }
    }

    function get_kasus()
    {
      $status = $this->session->userdata('status');
      $id = $this->session->userdata('id');
      $this->db->select('tbl_kasus.*');
      if ($status == 'user') {
        $this->db->join('tbl_kasus_user', 'tbl_kasus.id = tbl_kasus_user.id_kasus');
        $this->db->join('tbl_user', 'tbl_kasus_user.id_user = tbl_user.id');
        $this->db->where('tbl_user.id', $id);
      }
      $this->db->order_by('tbl_kasus.nama', 'asc');
      $query = $this->db->get('tbl_kasus');
      if ($query->num_rows() > 0) {
        return $query->result();
      } else {
        return false;
      }
    }

    public function cek_kasus()
    {
      $nama_kasus = strtoupper($this->input->post('val-nama_kasus'));
      $nama = strtoupper($this->input->post('val-nama'));

      $this->db->select('tbl_kasus.*');
      $this->db->where('upper(tbl_kasus.nama)', $nama);
      $this->db->where('tbl_kasus.deleted_at', null);

      $query = $this->db->get("tbl_kasus")->row();
      if ($query != null) {
        if ($nama == $nama_kasus) {
          return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    }
}
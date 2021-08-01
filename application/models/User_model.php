<?php

class User_model extends CI_Model
{

    function get_all()
    {
        $this->datatables->select('tbl_user.id, tbl_user.nama, tbl_role.nama as role');
        $this->datatables->from('tbl_user');
        $this->datatables->join('tbl_role_user', 'tbl_user.id = tbl_role_user.id_user');
        $this->datatables->join('tbl_role', 'tbl_role_user.id_role = tbl_role.id');
        $this->datatables->where('tbl_user.deleted_at', null);
        $this->datatables->add_column('view', '<a href="javascript:void(0);" class="btn btn-success" id="item-edit" data="$1">Edit</a> <a href="javascript:void(0);" class="btn btn-danger" id="item-delete" data="$1">Delete</a> <a href="javascript:void(0);" class="btn btn-primary" id="item-edit-password" data="$1">Edit Password</a>',
                                              'id');
        return $this->datatables->generate();
    }

    public function save()
    {
        $field = array(
            'nama' => $this->input->post('val-nama', TRUE),
            'username' => $this->input->post('val-username', TRUE),
            'password' => password_hash($this->input->post('val-password', TRUE), PASSWORD_BCRYPT),
        );
        $this->db->insert('tbl_user', $field);
        $id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            $id_role = $this->input->post('val-id_role', TRUE);
            if ($id_role) {
                $field1 = array(
                    'id_role' => $id_role,
                    'id_user' => $id
                );
                $this->db->insert('tbl_role_user', $field1);
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

    public function edit()
    {
        $id = $this->input->post('id');
        $this->db->select('tbl_user.id, tbl_user.nama, tbl_user.username, tbl_user.password, tbl_role.id as id_role');
        $this->db->join('tbl_role_user', 'tbl_user.id = tbl_role_user.id_user');
        $this->db->join('tbl_role', 'tbl_role_user.id_role = tbl_role.id');
        $this->db->where('tbl_user.deleted_at', null);
        $this->db->where('tbl_user.id', $id);
        $query = $this->db->get('tbl_user');
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
            'username' => $this->input->post('val-username', TRUE),
            'updated_at' => date("Y-m-d h:i:sa")
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_user', $field);
        if ($this->db->affected_rows() > 0) {
            $id_role = $this->input->post('val-id_role', TRUE);
            if ($id_role) {
                $field1 = array(
                    'id_role' => $id_role,
                );
                $this->db->where('id_user', $id);
                $this->db->update('tbl_role_user', $field1);
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

    public function password()
    {
        date_default_timezone_set("Asia/Bangkok");
        $id = $this->input->post('val-id');
        $field = array(
            'password' => password_hash($this->input->post('val-password', TRUE), PASSWORD_BCRYPT),
            'updated_at' => date("Y-m-d h:i:sa")
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_user', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_password()
    {
        $id = $this->session->userdata('id');
        $password = $this->input->post('val-password_', TRUE);
        $this->db->select('tbl_user.id, tbl_user.nama, tbl_user.username, tbl_user.password, tbl_role.nama as role');
        $this->db->join('tbl_role_user', 'tbl_user.id = tbl_role_user.id_user');
        $this->db->join('tbl_role', 'tbl_role_user.id_role = tbl_role.id');
        $this->db->where('tbl_user.deleted_at', null);
        $this->db->where('tbl_user.id', $id);
        $query = $this->db->get('tbl_user');
        if ($query->num_rows() == 1) {
            $hash = $query->row('password');
            if (password_verify($password, $hash)) {
                date_default_timezone_set("Asia/Bangkok");
                $field = array(
                    'password' => password_hash($this->input->post('val-password_update', TRUE), PASSWORD_BCRYPT),
                    'updated_at' => date("Y-m-d h:i:sa")
                );
                $this->db->where('id', $id);
                $this->db->update('tbl_user', $field);
                if ($this->db->affected_rows() > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('tbl_user');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_users()
    {
        $this->db->select('tbl_user.*');
        $this->db->join('tbl_role_user', 'tbl_user.id = tbl_role_user.id_user');
        $this->db->where('tbl_role_user.id_role', 1);
        $this->db->where('tbl_user.deleted_at', null);
        $query = $this->db->get('tbl_user');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}

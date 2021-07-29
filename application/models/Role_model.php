<?php

class Role_model extends CI_Model
{

    function get_all()
    {
        $this->datatables->select('tbl_role.id, tbl_role.nama');
        $this->datatables->from('tbl_role');
        $this->datatables->add_column('view', '<a class="item-edit" href="javascript:;" data="$1" style="color: green;font-size: 20px;">
                                        <i class="mdi mdi-pencil"></i></a> | 
                                        <a class="item-delete" href="javascript:;" data="$1" style="color: red;font-size: 20px;">
                                        <i class="mdi mdi-delete"></i></a>', 'id');
        return $this->datatables->generate();
    }

    public function save()
    {
        $field = array(
            'nama' => $this->input->post('val-nama', TRUE),
        );
        $this->db->insert('tbl_role', $field);
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
        $query = $this->db->get('tbl_role');
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
            'nama' => $this->input->post('val-nama', TRUE)
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_role', $field);
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
        $this->db->delete('tbl_role');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_roles()
    {
        $query = $this->db->get('tbl_role');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_role_menu()
    {
        $id = $this->input->post('id');
        $this->db->where('id_role', $id);
        $query = $this->db->get('tbl_role_menu');
        return $query->result();
    }

    function save_role_menu()
    {
        $id = $this->input->post('id');
        $menus = $this->input->post('data_menu');
        $this->db->delete('tbl_role_menu', array('id_role' => $id));
        if ($menus) {
            for ($i = 0; $i < count($menus); $i++) {
                $field = array(
                    'id_role' => $id,
                    'id_menu' => $menus[$i]
                );
                $this->db->insert('tbl_role_menu', $field);
            }
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function get_cek_role_menu($id_role, $id_menu)
    {
        $this->db->where('id_role', $id_role);
        $this->db->where('id_menu', $id_menu);
        $query = $this->db->get('tbl_role_menu');
        if ($query->row()) {
            return true;
        } else {
            return false;
        }
    }
}

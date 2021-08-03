<?php

class Menu_model extends CI_Model
{

    function get_all()
    {
        $this->datatables->select('tbl_menu.id, tbl_menu.nama, tbl_menu.icon, tbl_menu.label, tbl_menu.url, tbl_menu.urutan');
        $this->datatables->from('tbl_menu');
        $this->datatables->add_column('view', '<a href="javascript:void(0);" class="btn btn-success btn-sm" id="item-edit" data="$1">Edit</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="item-delete" data="$1">Delete</a>',
                                              'id');
        return $this->datatables->generate();
    }

    public function save()
    {
        $field = array(
            'nama' => $this->input->post('val-nama', TRUE),
            'icon' => $this->input->post('val-icon', TRUE),
            'label' => $this->input->post('val-label', TRUE),
            'url' => $this->input->post('val-url', TRUE),
            'urutan' => $this->input->post('val-urutan', TRUE),
        );
        $this->db->insert('tbl_menu', $field);
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
        $query = $this->db->get('tbl_menu');
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
            'icon' => $this->input->post('val-icon', TRUE),
            'label' => $this->input->post('val-label', TRUE),
            'url' => $this->input->post('val-url', TRUE),
            'urutan' => $this->input->post('val-urutan', TRUE),
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_menu', $field);
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
        $this->db->delete('tbl_menu');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_menus()
    {
        $this->db->order_by('label', 'ASC');
        $query = $this->db->get('tbl_menu');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_id_menu_by_url($url)
    {
        $this->db->where('url', $url);
        $query = $this->db->get('tbl_menu');
        return $query->row()->id;
    }
}

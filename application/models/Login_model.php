<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model
{

    function login($username, $password)
    {
        $this->db->select('tbl_user.id, tbl_user.nama, tbl_user.username, tbl_user.password, tbl_role.nama as role, tbl_role.id as id_role');
        $this->db->join('tbl_role_user', 'tbl_user.id = tbl_role_user.id_user');
        $this->db->join('tbl_role', 'tbl_role_user.id_role = tbl_role.id');
        $this->db->where('tbl_user.deleted_at', null);
        $this->db->where('username', $username);
        $query = $this->db->get('tbl_user');
        if ($query->num_rows() == 1) {
            $hash = $query->row('password');
            if (password_verify($password, $hash)) {
                return $query->row();
            } else {
                echo "Wrong Password. Try again.";
            }
        } else {
            echo "Account is not existed.";
        }
    }

    function update_ip($username, $password)
    {
        date_default_timezone_set("Asia/Bangkok");
        $field = array(
            'last_login' => date("Y-m-d h:i:sa"),
            'last_ip' => $this->input->ip_address()
        );
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $this->db->update('sc_praper.ref_user', $field);
    }
}

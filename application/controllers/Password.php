<?php

class Password extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('datatables');

        $this->load->model('Menu_model');
        $this->load->model('Role_model');

        $id_role = $this->session->userdata('id_role');
        // $id_menu = $this->Menu_model->get_id_menu_by_url(strtolower(get_class($this)));

        // $auth = $this->Role_model->get_cek_role_menu($id_role, $id_menu);
        if (!$id_role) {
            redirect(base_url('login'));
        }
    }

    function index()
    {
        $data = array(
            'page' => 'password'
        );
        $this->template->load('template', 'password', $data);
    }

    function list_()
    {
        header('Content-Type: application/json');
        echo $this->Password_model->get_all();
    }

    function save_()
    {
        $result = $this->Password_model->save();
        $msg['success'] = false;
        $msg['type'] = 'add';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function edit_()
    {
        $result = $this->Password_model->edit();
        echo json_encode($result);
    }

    public function update_()
    {
        $result = $this->User_model->update_password();
        $msg['success'] = false;
        $msg['type'] = 'update';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function delete_()
    {
        $result = $this->Password_model->delete();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }
}

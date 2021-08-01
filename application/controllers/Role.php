<?php

class Role extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Role_model');
        $this->load->model('Menu_model');
        $this->load->library('datatables');

        $id_role = $this->session->userdata('id_role');
        $id_menu = $this->Menu_model->get_id_menu_by_url(strtolower(get_class($this)));

        $auth = $this->Role_model->get_cek_role_menu($id_role, $id_menu);
        if (!$auth) {
            redirect(base_url('login'));
        }
    }

    function index()
    {
        $data = array(
            'page' => 'Role',
            'js' => [
                'public/assets/js/kweb/role/datatables.js',
				'public/assets/js/kweb/role/modal.js'
            ],
            'modals' => [
                $this->load->view('role/role_form')
            ]
        );
        $this->template->load('template', 'role/role_list', $data);
    }

    function list_()
    {
        header('Content-Type: application/json');
        echo $this->Role_model->get_all();
    }

    function save_()
    {
        $result = $this->Role_model->save();
        $msg['success'] = false;
        $msg['type'] = 'add';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function edit_()
    {
        $result = $this->Role_model->edit();
        echo json_encode($result);
    }

    public function update_()
    {
        $result = $this->Role_model->update();
        $msg['success'] = false;
        $msg['type'] = 'update';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function delete_()
    {
        $result = $this->Role_model->delete();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function get_menus_()
    {
        $result = $this->Menu_model->get_menus();
        echo json_encode($result);
    }

    public function get_role_menu_()
    {
        $result = $this->Role_model->get_role_menu();
        echo json_encode($result);
    }

    function save_role_menu_()
    {
        $result = $this->Role_model->save_role_menu();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }
}

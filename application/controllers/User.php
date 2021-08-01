<?php

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Role_model');
        $this->load->library('datatables');

        $this->load->model('Menu_model');

        $id_role = $this->session->userdata('id_role');
        $id_menu = $this->Menu_model->get_id_menu_by_url(strtolower(get_class($this)));

        $auth = $this->Role_model->get_cek_role_menu($id_role, $id_menu);
        if (!$auth) {
            redirect(base_url('login'));
        }
    }

    function index()
    {
        $role_data = $this->Role_model->get_roles();
        $data = array(
            'page' => 'User',
            'js' => [
				'public/assets/js/kweb/user/datatables.js',
				'public/assets/js/kweb/user/modal.js'
			],
            'modals' => [
                $this->load->view('user/user_form', ['role_data' => $role_data])
            ]
        );
        $this->template->load('template', 'user/user_list', $data);
    }

    function list_()
    {
        header('Content-Type: application/json');
        echo $this->User_model->get_all();
    }

    function save_()
    {
        $result = $this->User_model->save();
        $msg['success'] = false;
        $msg['type'] = 'add';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function edit_()
    {
        $result = $this->User_model->edit();
        echo json_encode($result);
    }

    public function update_()
    {
        $result = $this->User_model->update();
        $msg['success'] = false;
        $msg['type'] = 'update';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function password_()
    {
        $result = $this->User_model->password();
        $msg['success'] = false;
        $msg['type'] = 'update';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function delete_()
    {
        $result = $this->User_model->delete();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }
}

<?php

class Menu extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->load->library('datatables');

        $this->load->model('Role_model');

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
            'page' => 'Menu',
            'js' => [
                'public/assets/js/kweb/menu/datatables.js',
				'public/assets/js/kweb/menu/modal.js'
            ],
            'modals' => [
                $this->load->view('menu/menu_form')
            ]
        );
        $this->template->load('template', 'menu/menu_list', $data);
    }

    function list_()
    {
        header('Content-Type: application/json');
        echo $this->Menu_model->get_all();
    }

    function save_()
    {
        $result = $this->Menu_model->save();
        $msg['success'] = false;
        $msg['type'] = 'add';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function edit_()
    {
        $result = $this->Menu_model->edit();
        echo json_encode($result);
    }

    public function update_()
    {
        $result = $this->Menu_model->update();
        $msg['success'] = false;
        $msg['type'] = 'update';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function delete_()
    {
        $result = $this->Menu_model->delete();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Target extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Target_model');
        $this->load->model('Kasus_model');
        $this->load->library('datatables');

        $this->load->model('Menu_model');
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
        $kasus_data = $this->Kasus_model->get_kasus();
        $data = array(
            'page' => 'Target',
            'kasus_data' => $kasus_data,
            'js' => [
                'public/assets/js/kweb/target/datatables.js',
                'public/assets/js/kweb/target/modal.js',
                'public/assets/js/kweb/tracking/datatables.js',
                'public/assets/js/kweb/tracking/modal.js',
                'public/assets/js/kweb/tracking/chain-select.js'
            ],
            'modals' => [
                $this->load->view('target/target_form', ['kasus_data' => $kasus_data]),
                $this->load->view('tracking/tracking_form')
            ]
        );
        $this->template->load('template', 'target/target_list', $data);
    }

    function list_()
    {
        header('Content-Type: application/json');
        echo $this->Target_model->get_all();
    }

    function save_()
    {
        $result = $this->Target_model->save();
        $msg['success'] = false;
        $msg['type'] = 'add';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function edit_()
    {
        $result = $this->Target_model->edit();
        echo json_encode($result);
    }

    public function edit_target_()
    {
        $result = $this->Target_model->edit_target();
        echo json_encode($result);
    }

    public function update_()
    {
        $result = $this->Target_model->update();
        $msg['success'] = false;
        $msg['type'] = 'update';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function update_target_()
    {
        $result = $this->Target_model->update_target();
        $msg['success'] = false;
        $msg['type'] = 'update';
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function delete_()
    {
        $result = $this->Target_model->delete();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function delete_soft_()
    {
        $result = $this->Target_model->delete_soft();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    function recycle()
    {
        $kasus_data = $this->Kasus_model->get_kasus();
        $data = array(
            'page' => 'Target',
            'kasus_data' => $kasus_data,
            'js' => [
                'public/assets/js/kweb/target/datatables.js',
                'public/assets/js/kweb/target/modal.js'
            ]
        );
        $this->template->load('template', 'target/target_list_recycle', $data);
    }

    function list_recycle_()
    {
        header('Content-Type: application/json');
        echo $this->Target_model->get_recycle();
    }

    public function delete_all_()
    {
        $result = $this->Target_model->delete_all();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function restore_()
    {
        $result = $this->Target_model->restore();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function restore_all_()
    {
        $result = $this->Target_model->restore_all();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }

    public function update_tap_id_()
    {
        $result = $this->Target_model->update_tap_id();
        $msg['success'] = false;
        if ($result) {
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }
}

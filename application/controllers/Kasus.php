<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasus extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kasus_model');
		$this->load->model('User_model');
		$this->load->model('Menu_model');
		$this->load->model('Role_model');
		$this->load->library('datatables');

		$id_role = $this->session->userdata('id_role');
		$id_menu = $this->Menu_model->get_id_menu_by_url(strtolower(get_class($this)));

		$auth = $this->Role_model->get_cek_role_menu($id_role, $id_menu);
		if (!$auth) {
			redirect(base_url('login'));
		}
	}

  public function index()
	{
		$users_data = $this->User_model->get_users();
		$data = [
			'page' => 'Kasus',
			'js' => [
				'public/assets/js/kweb/kasus/datatables.js',
				'public/assets/js/kweb/kasus/modal.js'
			],
			'modals' => [
				$this->load->view('kasus/kasus_form', ['users_data' => $users_data])
			]
		];
		$this->template->load('template', 'kasus/kasus_list', $data);
	}

	public function list_()
	{
    header('Content-Type: application/json');
		echo $this->Kasus_model->get_all();
	}

	public function save_()
	{
		$result = $this->Kasus_model->save();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function edit_()
	{
		$result = $this->Kasus_model->edit();
		echo json_encode($result);
	}

	public function edit_kasus_()
	{
		$result = $this->Kasus_model->edit_kasus();
		echo json_encode($result);
	}

	public function update_()
	{
		$result = $this->Kasus_model->update();
		$msg['success'] = false;
		$msg['type'] = 'update';
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function update_kasus_()
	{
		$result = $this->Kasus_model->update_kasus();
		$msg['success'] = false;
		$msg['type'] = 'update';
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function delete_()
	{
		$result = $this->Kasus_model->delete();
		$msg['success'] = false;
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function delete_soft_()
	{
		$result = $this->Kasus_model->delete_soft();
		$msg['success'] = false;
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	function recycle()
	{
		$data = array(
			'page' => 'Kasus',
			'js' => [
				'public/assets/js/kweb/kasus/datatables.js',
				'public/assets/js/kweb/kasus/modal.js'
			]
		);
		$this->template->load('template', 'kasus/kasus_list_recycle', $data);
	}

	function list_recycle_()
	{
		header('Content-Type: application/json');
		echo $this->Kasus_model->get_recycle();
	}

	public function delete_all_()
	{
		$result = $this->Kasus_model->delete_all();
		$msg['success'] = false;
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function restore_()
	{
		$result = $this->Kasus_model->restore();
		$msg['success'] = false;
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function restore_all_()
	{
		$result = $this->Kasus_model->restore_all();
		$msg['success'] = false;
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function cek_kasus_()
	{
		$result = $this->Kasus_model->cek_kasus();
		echo json_encode($result);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Login_model');
    $this->load->model('Tracking_model');
  }

	public function index()
	{
		$this->load->view('auth/login');
	}

  public function login_action()
  {
    $username = $this->input->post('username', TRUE);
    $password = $this->input->post('password', TRUE);
    $login = $this->Login_model->login($username, $password);
    if ($login) {
        $this->session->set_userdata('id_role', $login->id_role);
        $this->session->set_userdata('status', strtolower($login->role));
        $this->session->set_userdata('id', $login->id);
        $this->session->set_userdata('username', $login->nama);
        $this->session->set_flashdata('message', 'Welcome ' . $login->username);
        if (strtolower($login->role) == 'admin user') {
            // redirect(base_url('user'));
            return 'Admin User';
        } else {
            redirect(base_url('kasus'));
        }
    } else {
      $this->session->set_flashdata('message', 'Username atau password salah!');
      redirect(base_url('login'));
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect(site_url(''));
  }

  public function insert_api_()
  {
    $result = $this->Tracking_model->insert_api();
    $msg['success'] = false;
    if ($result) {
        $msg['success'] = true;
    }
    echo json_encode($msg);
  }
}

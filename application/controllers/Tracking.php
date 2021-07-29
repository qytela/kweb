<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Tracking_model');
    $this->load->model('Kasus_model');
    $this->load->library('datatables');

    $auth = $this->session->userdata('id_role');
    if (!$auth) {
      redirect(base_url('login'));
    }
  }

  function index()
  {
    $kasus_data = $this->Kasus_model->get_kasus();
    $data = array(
      'page' => 'Tracking',
      'kasus_data' => $kasus_data,
    );
    $this->template->load('template', 'tracking', $data);
  }

  public function get_search_xy_()
  {
    $result = $this->Tracking_model->get_search_xy();
    echo json_encode($result);
  }

  public function get_search_()
  {
    $result = $this->Tracking_model->get_search();
    echo json_encode($result);
  }

  public function get_filter_xy_()
  {
    $result = $this->Tracking_model->get_filter_xy();
    echo json_encode($result);
  }

  public function get_filter_()
  {
    $result = $this->Tracking_model->get_filter();
    echo json_encode($result);
  }

  public function get_group_filter_xy_()
  {
    $result = $this->Tracking_model->get_group_filter_xy();
    echo json_encode($result);
  }

  public function get_group_filter_()
  {
    $result = $this->Tracking_model->get_group_filter();
    echo json_encode($result);
  }

  function get_provinsi_()
  {
    $data = $this->Tracking_model->get_provinsi();
    echo json_encode($data);
  }

  function get_kabkot_()
  {
    $data = $this->Tracking_model->get_kabkot();
    echo json_encode($data);
  }

  function get_kecamatan_()
  {
    $data = $this->Tracking_model->get_kecamatan();
    echo json_encode($data);
  }

  function get_kelurahan_()
  {
    $data = $this->Tracking_model->get_kelurahan();
    echo json_encode($data);
  }

  function get_nama_()
  {
    $data = $this->Tracking_model->get_nama();
    echo json_encode($data);
  }

  //master

  function list_()
  {
    header('Content-Type: application/json');
    echo $this->Tracking_model->get_all();
  }

  function save_()
  {
    $result = $this->Tracking_model->save();
    $msg['success'] = false;
    $msg['type'] = 'add';
    if ($result) {
      $msg['success'] = true;
    }
    echo json_encode($msg);
  }

  public function edit_()
  {
    $result = $this->Tracking_model->edit();
    echo json_encode($result);
  }

  public function update_()
  {
    $result = $this->Tracking_model->update();
    $msg['success'] = false;
    $msg['type'] = 'update';
    if ($result) {
      $msg['success'] = true;
    }
    echo json_encode($msg);
  }

  public function delete_()
  {
    $result = $this->Tracking_model->delete();
    $msg['success'] = false;
    if ($result) {
      $msg['success'] = true;
    }
    echo json_encode($msg);
  }

  public function delete_soft_()
  {
    $result = $this->Tracking_model->delete_soft();
    $msg['success'] = false;
    if ($result) {
      $msg['success'] = true;
    }
    echo json_encode($msg);
  }

  function recycle()
  {
    $data = array(
      'page' => 'tracking'
    );
    $this->load->view('tracking/tracking_list_recycle', $data);
  }

  function list_recycle_()
  {
    header('Content-Type: application/json');
    echo $this->Tracking_model->get_recycle();
  }

  public function delete_all_()
  {
    $result = $this->Tracking_model->delete_all();
    $msg['success'] = false;
    if ($result) {
      $msg['success'] = true;
    }
    echo json_encode($msg);
  }

  public function restore_()
  {
    $result = $this->Tracking_model->restore();
    $msg['success'] = false;
    if ($result) {
      $msg['success'] = true;
    }
    echo json_encode($msg);
  }

  public function restore_all_()
  {
    $result = $this->Tracking_model->restore_all();
    $msg['success'] = false;
    if ($result) {
      $msg['success'] = true;
    }
    echo json_encode($msg);
  }

  public function get_operator_()
  {
    $data = $this->Tracking_model->get_operator();
    echo json_encode($data);
  }
}

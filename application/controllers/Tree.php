<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tree extends CI_Controller
{
    var $column_order = array(null, 'EVENT_ID', null, null, 'ANUMBER', 'BNUMBER', 'STARTTIME', 'ENDTIME', 'EVENT_TYPE', 'DIRECTION', 'DATASIZE', 'DURATION', null); //set column field database for datatable orderable
    var $order = array('EVENT_ID' => 'asc');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tree_model');
        $this->load->model('Kasus_model');
        $this->load->model('Target_model');

        $this->load->model('Menu_model');
        $this->load->model('Role_model');

        $id_role = $this->session->userdata('id_role');
        $id_menu = $this->Menu_model->get_id_menu_by_url(strtolower(get_class($this)));

        $auth = $this->Role_model->get_cek_role_menu($id_role, $id_menu);
        if (!$auth) {
            redirect(base_url('login'));
        }
    }

    public function index()
    {
        $data = array(
            'page' => 'Tree',
            'js' => [
                'public/assets/js/kweb/tree/datatables.js'
            ]
        );
        $this->template->load('template', 'tree/tree_list', $data);
    }

    function list_()
    {
        if (isset($_POST['order'])) // here order processing
        {
            $sortby = $this->column_order[$_POST['order']['0']['column']];
            $descending = $_POST['order']['0']['dir'];
        } else if (isset($this->order)) {
            $order = $this->order;
            $sortby = key($order);
            $descending = $order[key($order)];
        }
        // var_dump($sortby);
        // var_dump($descending);

        $tap_id = $this->input->post('tap_id');
        $event_type_id = $this->input->post('event_type_id');
        $periodstart = $this->input->post('periodstart');
        $periodend = $this->input->post('periodend');
        $tanggal_status = $this->input->post('tanggal_status');

        $length = $this->input->post('length');
        $start = $this->input->post('start');

        $pagesize = $length;
        $pagenum = ($start / $length) + 1;


        if ($tap_id == null) {
            $tap_id = "[0]";
        } else {
            $data_tap = $this->get_target_by_tap_($tap_id);
            $tap_id =  array_map('intval', $tap_id);
            $tap_id =  json_encode($tap_id);
        }

        if ($tanggal_status == null) {
            $tanggal_status = "[0]";
        } else {
            $tanggal_status =  json_encode($tanggal_status);
        }

        $searchword = $_POST['search']['value'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->item('api_mc') . 'getDataTranscriptByTapid',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                        "tap_id": ' . $tap_id . ',
                                        "searchword" : "' . $searchword . '",
                                        "sortby" : "' . $sortby . '",
                                        "descending" : "' . $descending . '",
                                        "event_type_id" : "' . $event_type_id . '",
                                        "periodstart" : "' . $periodstart . '",
                                        "periodend" : "' . $periodend . '",
                                        "tanggalstatus": ' . $tanggal_status . ',
                                        "pagesize" : ' . $pagesize . ',
                                        "pagenum" : ' . $pagenum . '
                                    }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // echo $response;
        $data_tree = json_decode($response);
        // var_dump();

        $list = $data_tree->data;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $tree) {
            $taps = null;
            foreach ($data_tap as $element) {
                if (strval($tree->TAP_ID) == $element->tap_id) {
                    $taps = $element;
                }
            }
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['EVENT_ID'] = $tree->EVENT_ID;
            $row['NAMA_KASUS'] = $taps->nama_kasus;
            $row['NAMA_TARGET'] = $taps->nama_target;
            $row['ANUMBER'] = $tree->ANUMBER;
            $row['BNUMBER'] = $tree->BNUMBER;
            $row['STARTTIME'] = $tree->STARTTIME;
            $row['ENDTIME'] = $tree->ENDTIME;
            $row['EVENT_TYPE'] = $tree->EVENT_TYPE;
            $row['DIRECTION'] = $tree->DIRECTION;
            $row['DATASIZE'] = $tree->DATASIZE;
            $row['DURATION'] = $tree->DURATION;
            $row['PREVIEW'] = $tree->PREVIEW;

            // if ($tree->EVENT_TYPE == 'sms') {
            // } else {
            $content = '<div id="loading_run_' . $tree->EVENT_ID . '">
                                <img src="<?= base_url() ?>public/assets/images/loading_tracking.gif" width="15px" alt="">
                            </div>
                            <div id="loading_success_' . $tree->EVENT_ID . '">
                                <audio controls class="iru-tiny-player" data-title="' . $tree->EVENT_ID . '">
                                    <source id="source_audio_' . $tree->EVENT_ID . '" src="" type="audio/mpeg">
                                </audio>
                            </div>
                            <div id="loading_failed_' . $tree->EVENT_ID . '">
                                <h2 class"text-primary">Load file gagal..</h2>
                            </div>';
            // $row['PREVIEW'] = '<button type="button" data-toggle="popover" data-html="true" data-content="' . $content . '" data="' . $tree->EVENT_ID . '" class="btn btn-primary btn-xs item-play"><span class="btn-icon-left text-primary"><i class="fas fa-play-circle fa-lg"></i> </span>Play</button>';
            // }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $data_tree->recordsTotal,
            "recordsFiltered" => $data_tree->recordsFiltered,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function play_download_()
    {
        $id = $this->input->post('id');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->item('api_mc') . 'getwav',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                        "ID_EVENT":' . $id . '
                                    }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    function get_kasus_()
    {
        $result = $this->Kasus_model->get_kasus();
        echo json_encode($result);
    }

    function get_target_()
    {
        $result = $this->Target_model->get_target();
        echo json_encode($result);
    }

    function get_target_by_tap_($tap_id)
    {
        $result = $this->Target_model->get_target_by_tap($tap_id);
        return $result;
    }
}

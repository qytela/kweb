<?php

class Tracking_model extends CI_Model
{

    public function get_nama()
    {
        $status = $this->session->userdata('status');
        $id = $this->session->userdata('id');
        $this->db->select('tbl_kasus.id');
        if ($status == 'user') {
            $this->db->join('tbl_kasus_user', 'tbl_kasus.id = tbl_kasus_user.id_kasus');
            $this->db->join('tbl_user', 'tbl_kasus_user.id_user = tbl_user.id');
            $this->db->where('tbl_user.id', $id);
        }
        $this->db->order_by('tbl_kasus.nama', 'asc');
        $query1 = $this->db->get('tbl_kasus');
        $kasus = array_column($query1->result(), 'id');

        $id_kasus = $this->input->post('id');
        $this->db->select('tbl_target.id, tbl_target.nama');
        $this->db->from('tbl_target');
        if ($id_kasus) {
            $this->db->where('id_kasus', $id_kasus);
        } else {
            $this->db->where_in('id_kasus', $kasus);
        }
        $this->db->order_by('nama');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // public function get_search_xy()
    // {
    //     $nama = $this->input->post('val-nama');
    //     $no_telp = $this->input->post('val-no_telp');
    //     $date_awal = $this->input->post('date_awal');
    //     $date_akhir = $this->input->post('date_akhir');

    //     $this->db->select('id, no_telp, nama, waktu_update as time, latitude as lat, longitude as long,
    //                         country as negara, age as umur, lac, ci, imsi, imei, device');
    //     $this->db->from('tbl_target');
    //     $this->db->join(
    //         "(select distinct on (msisdn,latitude ,longitude) msisdn,waktu_update ,latitude ,longitude, country, age, lac, ci, imsi, imei, device  
    //                     from tbl_tracking_result 
    //                     where latitude is not null and latitude  <> 'NULL'
    //                     and sumber_api = 'gmlc'
    //                     order by msisdn,latitude ,longitude,waktu_update desc) ttr",
    //         'no_telp = msisdn',
    //         'left'
    //     );
    //     $this->db->where('waktu_update >=', $date_awal);
    //     $this->db->where('waktu_update <=', $date_akhir);
    //     $this->db->where("not (latitude is null or latitude = 'NULL')");
    //     if ($nama) {
    //         $this->db->where('tbl_target.nama', $nama);
    //     } else if ($no_telp) {
    //         $this->db->where('tbl_target.no_telp', $no_telp);
    //     }
    //     $this->db->order_by('waktu_update');
    //     $query = $this->db->get();
    //     if ($query->num_rows() > 0) {
    //         return $query->result();
    //     } else {
    //         return false;
    //     }
    // }

    public function get_search()
    {
        $nama = $this->input->post('val-nama');
        $id_kasus = $this->input->post('val-id_kasus');
        $no_telp = $this->input->post('val-no_telp');
        $date_awal = $this->input->post('date_awal');
        $date_akhir = $this->input->post('date_akhir');

        $this->db->select('tbl_target.id, no_telp, tbl_target.nama, waktu_update as time, latitude as lat, longitude as long,
                            country as negara, age as umur, lac, ci, imsi, imei, device, tracking_id');
        $this->db->from('tbl_target');
        $this->db->join('tbl_kasus', 'tbl_target.id_kasus = tbl_kasus.id');
        $this->db->join(
            "(select distinct on (msisdn,latitude ,longitude) tracking_id, msisdn,waktu_update ,latitude ,longitude, country, age, lac, ci, imsi, imei, device  
                                            from tbl_tracking_result 
                                            where latitude is not null and latitude  <> 'NULL'
                                            order by msisdn,latitude ,longitude,waktu_update desc) ttr",
            'no_telp = ttr.msisdn',
            'left'
        );
        $this->db->where('waktu_update >=', $date_awal);
        $this->db->where('waktu_update <=', $date_akhir);
        if ($id_kasus) {
            $this->db->where('id_kasus', $id_kasus);
        }
        $this->db->where("not (latitude is null or latitude = 'NULL')");
        if ($nama) {
            $this->db->where('tbl_target.id', $nama);
        } else if ($no_telp) {
            $this->db->where('tbl_target.no_telp', $no_telp);
        }
        $this->db->order_by('waktu_update');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // public function get_filter_xy()
    // {
    //     $nasional = $this->input->post('nasional');
    //     $provinsi = $this->input->post('provinsi');
    //     $kabkot = $this->input->post('kabkot');
    //     $kecamatan = $this->input->post('kecamatan');
    //     $kelurahan = $this->input->post('kelurahan');
    //     $date_awal = $this->input->post('date_awal');
    //     $date_akhir = $this->input->post('date_akhir');
    //     $this->db->select('id, no_telp, nama, waktu_update as time, latitude as lat, longitude as long,
    //                         country as negara, age as umur, lac, ci, imsi, imei, device');
    //     $this->db->from('tbl_target');
    //     $this->db->join(
    //         "(select distinct on (msisdn,latitude ,longitude) msisdn,waktu_update ,latitude ,longitude, country, age, lac, ci, imsi, imei, device  
    //                     from tbl_tracking_result 
    //                     where latitude is not null and latitude  <> 'NULL'
    //                     and sumber_api = 'gmlc'
    //                     order by msisdn,latitude ,longitude,waktu_update desc) ttr",
    //         'no_telp = msisdn',
    //         'left'
    //     );
    //     $this->db->where('waktu_update >=', $date_awal);
    //     $this->db->where('waktu_update <=', $date_akhir);
    //     $this->db->where("not (latitude is null or latitude = 'NULL')");
    //     if ($kelurahan) {
    //         $this->db->where('kelurahan', $kelurahan);
    //     } else if ($kecamatan) {
    //         $this->db->where('kecamatan', $kecamatan);
    //     } else if ($kabkot) {
    //         $this->db->where('kabkot', $kabkot);
    //     } else if ($provinsi) {
    //         $this->db->where('provinsi', $provinsi);
    //     } else if ($nasional) {
    //     }
    //     $this->db->order_by('waktu_update');
    //     $query = $this->db->get();
    //     if ($query->num_rows() > 0) {
    //         return $query->result();
    //     } else {
    //         return false;
    //     }
    // }

    public function get_filter()
    {
        $status = $this->session->userdata('status');
        $id = $this->session->userdata('id');
        $this->db->select('tbl_kasus.id');
        if ($status == 'user') {
            $this->db->join('tbl_kasus_user', 'tbl_kasus.id = tbl_kasus_user.id_kasus');
            $this->db->join('tbl_user', 'tbl_kasus_user.id_user = tbl_user.id');
            $this->db->where('tbl_user.id', $id);
        }
        $this->db->order_by('tbl_kasus.nama', 'asc');
        $query1 = $this->db->get('tbl_kasus');
        $kasus = array_column($query1->result(), 'id');

        $id_kasus = $this->input->post('id_kasus');
        $date_awal = $this->input->post('date_awal');
        $date_akhir = $this->input->post('date_akhir');
        $this->db->select('tbl_target.id, no_telp, tbl_target.nama, waktu_update as time, latitude as lat, longitude as long,
                            country as negara, age as umur, lac, ci, imsi, imei, device');
        $this->db->from('tbl_target');
        $this->db->join(
            "(select distinct on (msisdn,latitude ,longitude)tbl_tracking_result.tracking_id, msisdn,waktu_update ,latitude ,longitude, country, age, lac, ci, imsi, imei, device  
                        from tbl_tracking_result 
                        where latitude is not null and latitude  <> 'NULL'
                        order by msisdn,latitude ,longitude,waktu_update desc) ttr",
            'no_telp = ttr.msisdn',
            'left'
        );

        $this->db->where('waktu_update >=', $date_awal);
        $this->db->where('waktu_update <=', $date_akhir);
        if ($id_kasus) {
            $this->db->where('id_kasus', $id_kasus);
        } else {
            $this->db->where_in('id_kasus', $kasus);
        }
        $this->db->where("not (latitude is null or latitude = 'NULL')");
        $this->db->order_by('waktu_update');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // public function get_group_filter_xy()
    // {
    //     $nasional = $this->input->post('nasional');
    //     $provinsi = $this->input->post('provinsi');
    //     $kabkot = $this->input->post('kabkot');
    //     $kecamatan = $this->input->post('kecamatan');
    //     $kelurahan = $this->input->post('kelurahan');
    //     $date_awal = $this->input->post('date_awal');
    //     $date_akhir = $this->input->post('date_akhir');
    //     $this->db->select('DISTINCT ON (id) id');
    //     $this->db->from('tbl_target');
    //     $this->db->join(
    //         "(select distinct on (msisdn,latitude ,longitude) msisdn,waktu_update ,latitude ,longitude  
    //                     from tbl_tracking_result 
    //                     where latitude is not null and latitude  <> 'NULL'
    //                     and sumber_api = 'gmlc'
    //                     order by msisdn,latitude ,longitude,waktu_update desc) ttr",
    //         'no_telp = msisdn',
    //         'left'
    //     );
    //     $this->db->where('waktu_update >=', $date_awal);
    //     $this->db->where('waktu_update <=', $date_akhir);
    //     $this->db->where("not (latitude is null or latitude = 'NULL')");
    //     if ($kelurahan) {
    //         $this->db->where('kelurahan', $kelurahan);
    //     } else if ($kecamatan) {
    //         $this->db->where('kecamatan', $kecamatan);
    //     } else if ($kabkot) {
    //         $this->db->where('kabkot', $kabkot);
    //     } else if ($provinsi) {
    //         $this->db->where('provinsi', $provinsi);
    //     } else if ($nasional) {
    //     }
    //     $this->db->order_by('id');
    //     $this->db->group_by('id');
    //     $query = $this->db->get();
    //     if ($query->num_rows() > 0) {
    //         return $query->result();
    //     } else {
    //         return false;
    //     }
    // }

    public function get_group_filter()
    {
        $status = $this->session->userdata('status');
        $id = $this->session->userdata('id');
        $this->db->select('tbl_kasus.id');
        if ($status == 'user') {
            $this->db->join('tbl_kasus_user', 'tbl_kasus.id = tbl_kasus_user.id_kasus');
            $this->db->join('tbl_user', 'tbl_kasus_user.id_user = tbl_user.id');
            $this->db->where('tbl_user.id', $id);
        }
        $this->db->order_by('tbl_kasus.nama', 'asc');
        $query1 = $this->db->get('tbl_kasus');
        $kasus = array_column($query1->result(), 'id');

        $id_kasus = $this->input->post('id_kasus');
        $date_awal = $this->input->post('date_awal');
        $date_akhir = $this->input->post('date_akhir');
        $this->db->select('DISTINCT ON (id) tbl_target.id');
        $this->db->from('tbl_target');
        $this->db->join('tbl_kasus', 'tbl_target.id_kasus = tbl_kasus.id');
        $this->db->join(
            "(select distinct on (msisdn,latitude ,longitude)tbl_tracking_result.tracking_id, msisdn,waktu_update ,latitude ,longitude, country, age, lac, ci, imsi, imei, device  
                        from tbl_tracking_result 
                        where latitude is not null and latitude  <> 'NULL'
                        order by msisdn,latitude ,longitude,waktu_update desc) ttr",
            'no_telp = ttr.msisdn',
            'left'
        );
        $this->db->where('waktu_update >=', $date_awal);
        $this->db->where('waktu_update <=', $date_akhir);
        if ($id_kasus) {
            $this->db->where('id_kasus', $id_kasus);
        } else {
            $this->db->where_in('id_kasus', $kasus);
        }
        $this->db->where("not (latitude is null or latitude = 'NULL')");
        $this->db->order_by('tbl_target.id');
        $this->db->group_by('tbl_target.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_provinsi()
    {
        $this->db->select('*');
        $this->db->from('provinsi');
        $this->db->order_by('provinsi.nama');
        $query = $this->db->get();

        return $query->result();
    }

    function get_kabkot()
    {
        $id = $this->input->post('id');
        $this->db->select('id, nama');
        $this->db->from('kabkot');
        $this->db->where('kabkot.provinsi_id', $id);
        $this->db->order_by('kabkot.nama');
        $query = $this->db->get();

        return $query->result();
    }

    function get_kecamatan()
    {
        $id = $this->input->post('id');
        $this->db->select('id, nama');
        $this->db->from('kecamatan');
        $this->db->where('kecamatan.kabkot_id', $id);
        $this->db->order_by('kecamatan.nama');
        $query = $this->db->get();

        return $query->result();
    }

    function get_kelurahan()
    {
        $id = $this->input->post('id');
        $this->db->select('id, nama');
        $this->db->from('kelurahan');
        $this->db->where('kelurahan.kecamatan_id', $id);
        $this->db->order_by('kelurahan.nama');
        $query = $this->db->get();

        return $query->result();
    }

    //master

    function get_all()
    {
        $id_target = $this->input->post('id_target');
        $this->datatables->select("tracking_id, tipe_tracking, to_char(no_tracking, '999999999999999') as no_tracking, to_char(mulai_aktif, 'YYYY-MM-DD') as mulai_aktif,
                                to_char(akhir_aktif, 'YYYY-MM-DD') as akhir_aktif, status_target, operator");
        $this->datatables->from('tbl_tracking');
        $this->datatables->where('tbl_tracking.id_target', $id_target);
        $this->datatables->add_column('view', '<a href="javascript:void(0);" class="btn btn-success" id="item-edit" data="$1">Edit</a> <a href="javascript:void(0);" class="btn btn-danger" id="item-delete" data="$1">Delete</a>',
                                              'tracking_id');
        return $this->datatables->generate();
    }

    public function save()
    {
        date_default_timezone_set("Asia/Bangkok");
        $mulai_aktif_ = $this->input->post('val-mulai_aktif', TRUE);
        $mulai_aktif = date('Y-m-d', strtotime($mulai_aktif_)) . ' 00:00:00';
        $akhir_aktif_ = $this->input->post('val-akhir_aktif', TRUE);
        $akhir_aktif = date('Y-m-d', strtotime($akhir_aktif_)) . ' 00:00:00';
        $tanggal_status_ = $this->input->post('val-tanggal_status', TRUE);
        $tanggal_status = date('Y-m-d', strtotime($tanggal_status_)) . ' 00:00:00';
        $status_target = $this->input->post('val-status_target', TRUE);
        if ($status_target != 'aktif') {
            $tmp_status_target = 'tidak aktif by user';
        } else {
            $tmp_status_target = 'aktif';
        }
        if ($mulai_aktif_ < date("Y-m-d")) {
            $cdr = 1;
        } else {
            $cdr = 0;
        }
        $field = array(
            'no_tracking' => $this->input->post('val-no_tracking', TRUE),
            'tipe_tracking' => 'MSISDN',
            'mulai_aktif' => $mulai_aktif,
            'akhir_aktif' => $akhir_aktif,
            'status_target' => $status_target,
            'tanggal_status' => $tanggal_status,
            'tmp_status_target' => $tmp_status_target,
            'operator' => $this->input->post('val-operator', TRUE),
            'last_update' => date("Y-m-d h:i:sa"),
            'id_target' => $this->input->post('val-id_target_tracking', TRUE),
            'cdr' => $cdr,
            'tgl_mulai_cdr' => date('Y-m-d', strtotime($mulai_aktif_)),
        );
        $this->db->insert('tbl_tracking', $field);
        if ($this->db->affected_rows() > 0) {

            return true;
        } else {
            return false;
        }
    }

    public function insert_api()
    {
        $this->db->select('tracking_id, no_tracking, mulai_aktif, akhir_aktif, status_target, last_update');
        $this->db->from('tbl_tracking');
        $this->db->where("last_update <=", "now()");
        $this->db->where('last_update >= mulai_aktif');
        $this->db->where('last_update <= akhir_aktif');
        $this->db->order_by('tbl_tracking.no_tracking');
        $query = $this->db->get();
        $data_tracking = $query->result_array();

        foreach ($data_tracking as $tracking) {
            $no = $tracking['no_tracking'];
            $temp = file_get_contents('http://172.20.1.11/job/xml.php?msisdn=' . $no);
            $xml = simplexml_load_string($temp);
            if (isset($xml->slia->pos->pd) == false) {
            } else {
                date_default_timezone_set("Asia/Bangkok");
                $this->db->update('tbl_tracking', array('last_update' => date("Y-m-d h:i:sa")));

                if (isset($xml->slia->pos->pd->shape->CircularArcArea) == false) {
                    $x = (string) $xml->slia->pos->pd->shape->EllipticalArea->coord->X;
                    $y = (string) $xml->slia->pos->pd->shape->EllipticalArea->coord->Y;
                    $z = (string) $xml->slia->pos->pd->shape->EllipticalArea->coord->Z;
                } else {
                    $x = (string) $xml->slia->pos->pd->shape->CircularArcArea->coord->X;
                    $y = (string) $xml->slia->pos->pd->shape->CircularArcArea->coord->Y;
                    $z = (string) $xml->slia->pos->pd->shape->CircularArcArea->coord->Z;
                }

                $date = strtotime($xml->slia->pos->pd->time);
                $waktu_update = date('Y-m-d H:i:s', $date);
                $lat = null;
                $long = null;
                $x_ = rtrim($x, "S");
                $y_ = rtrim($y, "W");
                $x_ = rtrim($x_, "N");
                $y_ = rtrim($y_, "E");
                $arr_x = explode(" ", $x_);
                $arr_y = explode(" ", $y_);
                $d_x = (int)$arr_x[0];
                $d_y = (int)$arr_y[0];
                $m_x = (int)$arr_x[1];
                $m_y = (int)$arr_y[1];
                $s_x = (float)$arr_x[2];
                $s_y = (float)$arr_y[2];
                if (substr($x, -1) == "S") {
                    $lat = (($d_x) + ($m_x / 60) + ($s_x / 3600)) * -1;
                } else {
                    $lat = (($d_x) + ($m_x / 60) + ($s_x / 3600));
                }
                if (substr($y, -1) == "W") {
                    $long = (($d_y) + ($m_y / 60) + ($s_y / 3600)) * -1;
                } else {
                    $long = (($d_y) + ($m_y / 60) + ($s_y / 3600));
                }
                $field = array(
                    'tracking_id' => $tracking['tracking_id'],
                    'msisdn' => (string) $xml->slia->pos->msid,
                    'latitude' => $lat,
                    'longitude' => $long,
                    'mcc' => (string) $xml->slia->pos->cs_response_ext->serving_cell->mcc,
                    'mnc' => (string) $xml->slia->pos->cs_response_ext->serving_cell->mnc,
                    'operator' => (string) $xml->slia->pos->cs_response_ext->serving_cell->operator,
                    'age' => (string) $xml->slia->pos->cs_response_ext->gmlc_data->age_of_location,
                    'lac' => (string) $xml->slia->pos->cs_response_ext->serving_cell->lac,
                    'ci' => (string)$xml->slia->pos->cs_response_ext->serving_cell->cellid,
                    'imsi_' => (string) $xml->slia->pos->cs_response_ext->gmlc_data->imsi,
                    'waktu_update' => (string) $waktu_update,
                    'coord_x' => $x,
                    'coord_y' => $y,
                    'coord_z' => $z,
                    'sumber_api' => 'gmlc',
                );
                $gmlc = $this->db->insert('tbl_tracking_result', $field);
                if ($gmlc) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $this->db->where('tracking_id', $id);
        $query = $this->db->get('tbl_tracking');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function update()
    {
        date_default_timezone_set("Asia/Bangkok");
        $id = $this->input->post('val-id');
        $mulai_aktif_ = $this->input->post('val-mulai_aktif', TRUE);
        $mulai_aktif = date('Y-m-d', strtotime($mulai_aktif_)) . ' 00:00:00';
        $akhir_aktif_ = $this->input->post('val-akhir_aktif', TRUE);
        $akhir_aktif = date('Y-m-d', strtotime($akhir_aktif_)) . ' 00:00:00';
        $tanggal_status_ = $this->input->post('val-tanggal_status', TRUE);
        $tanggal_status = date('Y-m-d', strtotime($tanggal_status_)) . ' 00:00:00';
        $status_target = $this->input->post('val-status_target', TRUE);
        if ($status_target != 'aktif') {
            $tmp_status_target = 'tidak aktif by user';
        } else {
            $tmp_status_target = 'aktif';
        }
        $field = array(
            'no_tracking' => $this->input->post('val-no_tracking', TRUE),
            'mulai_aktif' => $mulai_aktif,
            'akhir_aktif' => $akhir_aktif,
            'status_target' => $status_target,
            'tanggal_status' => $tanggal_status,
            'tmp_status_target' => $tmp_status_target,
            'operator' => $this->input->post('val-operator', TRUE),
            'last_update' => date("Y-m-d h:i:sa"),
        );
        $this->db->where('tracking_id', $id);
        $this->db->update('tbl_tracking', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('tracking_id', $id);
        $this->db->delete('tbl_tracking');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_soft()
    {
        $id = $this->input->post('id');
        date_default_timezone_set("Asia/Bangkok");
        $field = array(
            'deleted_at' => date("Y-m-d h:i:sa")
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_tracking', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_all()
    {
        $this->db->where('deleted_at is not null', null, false);
        $this->db->delete('tbl_tracking');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function restore()
    {
        $id = $this->input->post('id');
        date_default_timezone_set("Asia/Bangkok");
        $field = array(
            'deleted_at' => null
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_tracking', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function restore_all()
    {
        date_default_timezone_set("Asia/Bangkok");
        $field = array(
            'deleted_at' => null
        );
        $this->db->where('deleted_at is not null', null, false);
        $this->db->update('tbl_tracking', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_operator()
    {
        $prefix = substr($this->input->post('prefix'), 0, 5);
        $this->db->select('tbl_operator.nm_operator');
        $this->db->from('tbl_operator');
        $this->db->where('tbl_operator.prefix', $prefix);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
}

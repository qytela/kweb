<?php

class Tree_model extends CI_Model
{

    public function get_filter()
    {
        // $nasional = $this->input->post('nasional');
        // $provinsi = $this->input->post('provinsi');
        // $kabkot = $this->input->post('kabkot');
        // $kecamatan = $this->input->post('kecamatan');
        // $kelurahan = $this->input->post('kelurahan');

        $id_kasus = $this->input->post('id_kasus');
        $date_awal = $this->input->post('date_awal');
        $date_akhir = $this->input->post('date_akhir');
        $this->db->select('tbl_target.id, no_telp, tbl_target.nama, waktu_update as time, latitude as lat, longitude as long,
                            country as negara, age as umur, lac, ci, imsi, imei, device');
        $this->db->from('tbl_target');
        $this->db->join('tbl_kasus', 'tbl_target.id_kasus = tbl_kasus.id');
        $this->db->join('tbl_tracking', 'tbl_target.id = tbl_tracking.id_target');
        $this->db->join(
            "(select distinct on (msisdn,latitude ,longitude)tbl_tracking_result.tracking_id, msisdn,waktu_update ,latitude ,longitude, country, age, lac, ci, imsi, imei, device  
                        from tbl_tracking_result 
                        where latitude is not null and latitude  <> 'NULL'
                        order by msisdn,latitude ,longitude,waktu_update desc) ttr",
            'tbl_tracking.tracking_id = ttr.tracking_id',
            'left'
        );
        $this->db->where('waktu_update >=', $date_awal);
        $this->db->where('waktu_update <=', $date_akhir);
        $this->db->where_in('tbl_target.id_kasus', $id_kasus);
        $this->db->where("not (latitude is null or latitude = 'NULL')");
        $this->db->order_by('waktu_update');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_group_filter()
    {
        // $nasional = $this->input->post('nasional');
        // $provinsi = $this->input->post('provinsi');
        // $kabkot = $this->input->post('kabkot');
        // $kecamatan = $this->input->post('kecamatan');
        $id_kasus = $this->input->post('id_kasus');
        $date_awal = $this->input->post('date_awal');
        $date_akhir = $this->input->post('date_akhir');
        $this->db->select('DISTINCT ON (id) tbl_target.id');
        $this->db->from('tbl_target');
        $this->db->join('tbl_kasus', 'tbl_target.id_kasus = tbl_kasus.id');
        $this->db->join('tbl_tracking', 'tbl_target.id = tbl_tracking.id_target');
        $this->db->join(
            "(select distinct on (msisdn, latitude ,longitude)tbl_tracking_result.tracking_id, msisdn,waktu_update ,latitude ,longitude  
                        from tbl_tracking_result 
                        where latitude is not null and latitude  <> 'NULL'
                        order by msisdn,latitude ,longitude,waktu_update desc) ttr",
            'tbl_tracking.tracking_id = ttr.tracking_id',
            'left'
        );
        $this->db->where('waktu_update >=', $date_awal);
        $this->db->where('waktu_update <=', $date_akhir);
        $this->db->where("not (latitude is null or latitude = 'NULL')");
        $this->db->where_in('tbl_target.id_kasus', $id_kasus);
        // if ($kelurahan) {
        //     $this->db->where_in('kelurahan', $kelurahan);
        // }
        // if ($kecamatan) {
        //     $this->db->where_in('kecamatan', $kecamatan);
        // }
        // if ($kabkot) {
        //     $this->db->where_in('kabkot', $kabkot);
        // }
        // if ($provinsi) {
        //     $this->db->where_in('provinsi', $provinsi);
        // }
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
        $this->db->select('*');
        $this->db->from('kabkot');
        $this->db->where('kabkot.provinsi_id', $id);
        $this->db->order_by('kabkot.nama');
        $query = $this->db->get();

        return $query->result();
    }

    function get_kecamatan()
    {
        $id = $this->input->post('id');
        $this->db->select('*');
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
}

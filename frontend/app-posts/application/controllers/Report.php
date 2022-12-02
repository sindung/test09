<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function index() {
        $array = array();

        $data = array(
            'app_title' => 'App Parkir - Report',
            'app_heading' => 'Report',
            'app_content' => $this->parser->parse('report/report_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list() {
        $this->load->helper('url');

        $list = $this->model_FormCheckOut->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        foreach ($list as $produk) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $produk->id . '">';
            $row[] = $produk->nomor_polisi;
            $row[] = $produk->tanggal_dan_jam_masuk;
            $row[] = $produk->tanggal_dan_jam_masuk;
            $row[] = $produk->tanggal_keluar;
            $row[] = $produk->jam_keluar;
            $row[] = $produk->jenis_kendaraan;
            $row[] = number_format($produk->biaya_parkir, 0, '', '');

            //add html for action
//            $row[] = '<a class="btn btn-sm btn-outline-info mr-1" href="javascript:void(0)" title="Edit" onclick="ubah_produk(' . "'" . $produk->id . "'" . ')"><i class="fas fa-edit"></i></a>'
//                    . '<a class="btn btn-sm btn-outline-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_produk(' . "'" . $produk->id . "'" . ')"><i class="fas fa-trash"></i></a>';
            $row[] = "";

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_FormCheckOut->count_all(),
            "recordsFiltered" => $this->model_FormCheckOut->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->model_FormCheckOut->get_by_id($id);
        $data->harga = number_format($data->harga, 0, '', '');

        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();

        $data = array(
            'nomor_polisi' => $this->input->post('nomor_polisi'),
            'tanggal_dan_jam_masuk' => $this->input->post('tanggal_masuk') . " " . $this->input->post('jam_masuk'),
            'jenis_kendaraan' => $this->input->post('jenis_kendaraan'),
            'tanggal_keluar' => $this->input->post('tanggal_keluar'),
            'jam_keluar' => $this->input->post('tanggal_keluar') . " " . $this->input->post('jam_keluar'),
            'biaya_parkir' => $this->input->post('biaya_parkir')
        );

        $insert = $this->model_FormCheckOut->save($data);

        echo json_encode(array("status" => true));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'nama' => $this->input->post('nama'),
            'harga' => $this->input->post('harga')
        );
        $this->model_FormCheckOut->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => true));
    }

    public function ajax_delete($id) {
        $this->model_FormCheckOut->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_FormCheckOut->delete_by_id($id);
        }
        echo json_encode(array("status" => true));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('nomor_polisi') == '') {
            $data['inputerror'][] = 'nomor_polisi';
            $data['error_string'][] = 'Nomor Polisi tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('tanggal_masuk') == '') {
            $data['inputerror'][] = 'tanggal_masuk';
            $data['error_string'][] = 'Tanggal Masuk tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('jam_masuk') == '') {
            $data['inputerror'][] = 'jam_masuk';
            $data['error_string'][] = 'Jam Masuk tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('tanggal_keluar') == '') {
            $data['inputerror'][] = 'tanggal_keluar';
            $data['error_string'][] = 'Tanggal Keluar tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('jam_keluar') == '') {
            $data['inputerror'][] = 'jam_keluar';
            $data['error_string'][] = 'Jam Keluar tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('jenis_kendaraan') == '') {
            $data['inputerror'][] = 'jenis_kendaraan';
            $data['error_string'][] = 'Jenis Kendaraan tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('biaya_parkir') == '') {
            $data['inputerror'][] = 'biaya_parkir';
            $data['error_string'][] = 'Biaya Parkir tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FormCheckIn extends CI_Controller {

    public function index() {
        $array = array();

        $data = array(
            'app_title' => 'App Parkir - Form Check In',
            'app_heading' => 'Form Check In',
            'app_content' => $this->parser->parse('form/FormCheckIn_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list() {
        $this->load->helper('url');

        $list = $this->model_FormCheckIn->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        foreach ($list as $produk) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $produk->id . '">';
            $row[] = $produk->nomor_polisi;
            $row[] = date_format(date_create($produk->tanggal), "d M Y");
            $row[] = date_format(date_create($produk->jam), "H:i:s");
            $row[] = $produk->jenis_kendaraan;
            $row[] = $produk->created_at;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-outline-info mr-1" href="javascript:void(0)" title="Edit" onclick="ubah_produk(' . "'" . $produk->id . "'" . ')"><i class="fas fa-edit"></i></a>'
                    . '<a class="btn btn-sm btn-outline-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_produk(' . "'" . $produk->id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_FormCheckIn->count_all(),
            "recordsFiltered" => $this->model_FormCheckIn->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->model_FormCheckIn->get_by_id($id);
        $data->harga = number_format($data->harga, 0, '', '');

        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();

        $data = array(
            'nomor_polisi' => $this->input->post('nomor_polisi'),
            'jenis_kendaraan' => $this->input->post('jenis_kendaraan')
        );

        $insert = $this->model_FormCheckIn->save($data);

        echo json_encode(array("status" => true));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'nama' => $this->input->post('nama'),
            'harga' => $this->input->post('harga')
        );
        $this->model_FormCheckIn->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => true));
    }

    public function ajax_delete($id) {
        $this->model_FormCheckIn->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_FormCheckIn->delete_by_id($id);
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

        if ($this->input->post('jenis_kendaraan') == '') {
            $data['inputerror'][] = 'jenis_kendaraan';
            $data['error_string'][] = 'Jenis Kendaraan tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

}

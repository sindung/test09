<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function index() {
        $array = array();

        $data = array(
            'app_title' => 'App Kasir - Produk',
            'app_heading' => 'Produk View',
            'app_content' => $this->parser->parse('produk/produk_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list() {
        $this->load->helper('url');

        $list = $this->model_produk->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        foreach ($list as $produk) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $produk->id . '">';
            $row[] = $produk->nama;
            $row[] = number_format($produk->harga, 0, '', '');

            //add html for action
            $row[] = '<a class="btn btn-sm btn-outline-info mr-1" href="javascript:void(0)" title="Edit" onclick="ubah_produk(' . "'" . $produk->id . "'" . ')"><i class="fas fa-edit"></i></a>'
                    . '<a class="btn btn-sm btn-outline-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_produk(' . "'" . $produk->id . "'" . ')"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_produk->count_all(),
            "recordsFiltered" => $this->model_produk->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->model_produk->get_by_id($id);
        $data->harga = number_format($data->harga, 0, '', '');

        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();

        $data = array(
            'nama' => $this->input->post('nama'),
            'harga' => $this->input->post('harga')
        );

        $insert = $this->model_produk->save($data);

        echo json_encode(array("status" => true));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'nama' => $this->input->post('nama'),
            'harga' => $this->input->post('harga')
        );
        $this->model_produk->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => true));
    }

    public function ajax_delete($id) {
        $this->model_produk->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_produk->delete_by_id($id);
        }
        echo json_encode(array("status" => true));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('nama') == '') {
            $data['inputerror'][] = 'nama';
            $data['error_string'][] = 'Nama tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('harga') == '') {
            $data['inputerror'][] = 'harga';
            $data['error_string'][] = 'Harga tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

}

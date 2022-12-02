<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AllPosts extends CI_Controller {

    public function index() {
        $array = array();

        $data = array(
            'app_title' => 'All Posts',
            'app_heading' => 'All Posts',
            'app_content' => $this->parser->parse('posts/dashboard', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list() {
        $this->load->helper('url');

        $list = $this->model_Posts->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        foreach ($list as $posts) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $posts->id . '">';
            $row[] = $posts->title;
            $row[] = $posts->content;
            $row[] = $posts->category;
            $row[] = date_format(date_create($posts->created_date), "d M Y H:i:s");
            $row[] = $posts->updated_date !== null ? date_format(date_create($posts->updated_date), "d M Y H:i:s") : "<i class=\"text-muted\">not set</i>";
            $row[] = $posts->status;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-outline-info mr-1 ubah-data" data-id="' . $posts->id . '" href="javascript:void(0)" title="Edit"><i class="fas fa-edit"></i></a>'
                    . '<a class="btn btn-sm btn-outline-danger mr-1 hapus-data" data-id="' . $posts->id . '" href="javascript:void(0)" title="Hapus"><i class="fas fa-trash"></i></a>'
                    . '<a class="btn btn-sm btn-outline-secondary mr-1 status-data" data-id="' . $posts->id . '" data-status="Draft" href="javascript:void(0)" title="Status">Draft</a>'
                    . '<a class="btn btn-sm btn-outline-success mr-1 status-data" data-id="' . $posts->id . '" data-status="Publish" href="javascript:void(0)" title="Status">Publish</a>'
                    . '<a class="btn btn-sm btn-outline-success preview" data-id="' . $posts->id . '" data-preview="' . site_url('AllPosts/preview/') . '" href="javascript:void(0)" title="Preview">Preview</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_Posts->count_all(),
            "recordsFiltered" => $this->model_Posts->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->model_Posts->get_by_id($id);

        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();

        $data = array(
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'category' => $this->input->post('category')
        );

        $insert = $this->model_Posts->save($data);

        echo json_encode(array("status" => true));
    }

    public function ajax_update() {
        $this->_validate();
        $data = array(
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'category' => $this->input->post('category'),
            'updated_date' => date('Y-m-d H:i:s')
        );
        $this->model_Posts->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => true));
    }

    public function ajax_update_status() {
        $res = array();
        $res['error_string'] = array();
        $res['inputerror'] = array();
        $res['status'] = true;

        if ($this->input->post('status') == '') {
            $res['inputerror'][] = 'status';
            $res['error_string'][] = 'status tidak boleh kosong';
            $res['status'] = false;
        }

        if ($res['status'] === false) {
            exit();
        }

        $data = array(
            'status' => $this->input->post('status'),
            'updated_date' => date('Y-m-d H:i:s')
        );
        $this->model_Posts->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => true, "data" => $this->input->post()));
    }

    public function ajax_delete($id) {
        $this->model_Posts->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_Posts->delete_by_id($id);
        }
        echo json_encode(array("status" => true));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('title') == '') {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'Title tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('content') == '') {
            $data['inputerror'][] = 'content';
            $data['error_string'][] = 'Content tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('category') == '') {
            $data['inputerror'][] = 'category';
            $data['error_string'][] = 'Category tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function preview($id = null) {
        $preview = "";

        if ($id !== null) {
            $preview = $this->model_Posts->get_by_id($id);
        }

        $data = array(
            'app_title' => 'Preview',
            'app_heading' => 'Preview',
            'app_content' => $preview->content
        );

        $this->parser->parse('app_template', $data);
    }

}

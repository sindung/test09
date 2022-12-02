<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Article extends REST_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index_get($id = null, $limit = null, $offset = null) {
        if ($id === null) {
            $id = $this->get('id');
        }
        if ($limit === null) {
            $limit = $this->get('limit');
        }
        if ($offset === null) {
            $offset = $this->get('offset');
        }
        if ($id === NULL) {
            $posts = $this->model_posts->getPosts(null, $limit, $offset);
        } else {
            $posts = $this->model_posts->getPosts($id, $limit, $offset);
        }

        if ($posts) {
            $this->response([
                'status' => TRUE,
                'data' => $posts], REST_Controller::HTTP_OK
            );
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'data tidak ditemukan'], REST_Controller::HTTP_NOT_FOUND
            );
        }
    }

    public function index_post($id = null) {
        $data = array(
            'title' => $this->post('title'),
            'content' => $this->post('content'),
            'category' => $this->post('category'),
            'status' => $this->post('status')
        );
        if ($id !== null) {
            $data['id'] = $id;
            $this->update_post($data);
        } else {
            $this->insert_post($data);
        }
    }

    public function index_put($id = null) {
        $data = array(
            'title' => $this->put('title'),
            'content' => $this->put('content'),
            'category' => $this->put('category'),
            'status' => $this->put('status')
        );
        if ($id !== null) {
            $data['id'] = $id;
        }

        $this->update_post($data);
    }

    public function index_patch($id = null) {
        $data = array(
            'title' => $this->patch('title'),
            'content' => $this->patch('content'),
            'category' => $this->patch('category'),
            'status' => $this->patch('status')
        );
        if ($id !== null) {
            $data['id'] = $id;
        }

        $this->update_post($data);
    }

    public function insert_post($data) {
        if ($this->model_posts->replacePosts($data) > 0) {
            // ok
            $this->response([
                'status' => TRUE,
                'data' => $data,
                'message' => 'inserted!'], REST_Controller::HTTP_OK
            );
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'data format wrong!'], REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }

    public function update_post($data) {
        $data['updated_date'] = date('Y-m-d H:i:s');

        if ($this->model_posts->replacePosts($data) > 0) {
            // ok
            $this->response([
                'status' => TRUE,
                'data' => $data,
                'message' => 'updated!'], REST_Controller::HTTP_OK
            );
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'data format wrong!'], REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_delete($id = null) {
        if ($id === null) {
            $id = $this->delete('id');
        }
        if ($id === NULL) {
            $this->response([
                'status' => FALSE,
                'message' => 'provide an id!'], REST_Controller::HTTP_BAD_REQUEST
            );
        } else {
            if ($this->model_posts->deletePosts($id) > 0) {
                // ok
                $this->response([
                    'status' => TRUE,
                    'id' => $id,
                    'message' => 'deleted!'], REST_Controller::HTTP_NO_CONTENT
                );
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'id not found!'], REST_Controller::HTTP_BAD_REQUEST
                );
            }
        }
    }

}

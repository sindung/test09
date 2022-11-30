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

class Mahasiswa extends REST_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index_get() {
        $id = $this->get('id');
        if ($id === NULL) {
            $mahasiswa = $this->model_mahasiswa->getMahasiswa();
        } else {
            $mahasiswa = $this->model_mahasiswa->getMahasiswa($id);
        }

        if ($mahasiswa) {
            $this->response([
                'status' => TRUE,
                'data' => $mahasiswa], REST_Controller::HTTP_OK
            );
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'data tidak ditemukan'], REST_Controller::HTTP_NOT_FOUND
            );
        }
    }

    public function index_delete() {
        $id = $this->delete('id');
        if ($id === NULL) {
            $this->response([
                'status' => FALSE,
                'message' => 'provide an id!'], REST_Controller::HTTP_BAD_REQUEST
            );
        } else {
            if ($this->model_mahasiswa->deleteMahasiswa($id) > 0) {
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

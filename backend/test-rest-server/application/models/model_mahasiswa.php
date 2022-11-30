<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_mahasiswa extends CI_Model {

    function __construct() {
        
    }

    public function getMahasiswa($id = null) {
        if ($id === null) {
            return $this->db->get('mahasiswa')->result_array();
        } else {
            return $this->db->get_where('mahasiswa', ['id' => $id])->result_array();
        }
    }

    public function deleteMahasiswa($id) {
        $this->db->delete('mahasiswa', ['id' => $id]);
        return $this->db->affected_rows();
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_posts extends CI_Model {

    function __construct() {

    }

    public function getPosts($id = null, $limit = null, $offset = null) {
        if ($limit !== null) {
            $this->db->limit($limit);
        }
        if ($offset !== null) {
            $this->db->offset($offset);
        }

        if ($id === null) {
            return $this->db->get('posts')->result_array();
        } else {
            return $this->db->get_where('posts', ['id' => $id])->result_array();
        }
    }

    public function replacePosts($data) {
        $this->db->set($data);
        $this->db->replace('posts');
        return $this->db->affected_rows();
    }

    public function updatePosts($id) {
        $this->db->delete('posts', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deletePosts($id) {
        $this->db->delete('posts', ['id' => $id]);
        return $this->db->affected_rows();
    }

}

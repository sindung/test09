<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->penjualan();
    }

    public function penjualan() {
        $array = array();

        $data = array(
            'app_title' => 'App Kasir - Transaksi',
            'app_heading' => 'Penjualan',
            'app_content' => $this->parser->parse('transaksi/penjualan_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

}

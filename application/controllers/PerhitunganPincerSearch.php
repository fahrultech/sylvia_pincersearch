<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganPincerSearch extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
    }
    function index(){
        $this->load->view("header");
        $this->load->view("sidebar");
        $this->load->view("perhitunganpincersearch");
        $this->load->view("footer");
    }
}
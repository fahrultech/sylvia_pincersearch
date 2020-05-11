<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller{
  
    function __construct(){
        parent::__construct();
        if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
        }
        $this->load->model('Profile_model');
    }
    function index(){
        $newdata = $this->Profile_model->getAll();
        $data = array("id" => $newdata[0]->idAdmin,"nama" => $newdata[0]->nama,"username" =>$newdata[0]->username);
        $this->load->view("header");
        $this->load->view("sidebar");
        $this->load->view("profile",$data);
        $this->load->view("footer");
    }
    function simpan(){
        $this->form_validation->set_rules('username','username', 'required|trim|xss_clean', 
            array('required' => 'Username Harus Diisi'));
        $this->form_validation->set_rules('nama','nama', 'required|trim|xss_clean',
            array('required' => 'Password Harus Diisi'));
        if($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $id = $this->input->post('id');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $nama = $this->input->post('nama');
            $data = array("nama" => $nama,"username" => $username);
            $password == "" ? 
               $data = array("nama" =>$nama,"username" => $username) : 
               $data = array("nama" =>$nama,"username" => $username,"password" => md5($password));
            $q = $this->Profile_model->update(array("idAdmin" => $id),$data);
            $password == "" ? redirect('/') : redirect('/admin/logout');
        }
    }
}
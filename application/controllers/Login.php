<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        if($this->session->userdata('username')){
            redirect(base_url('admin'));
        }
        $this->load->model(array('Login_model'));
    }
    function index(){
        $this->load->view('login');
    }

    function proses(){
        $this->form_validation->set_rules('username','username', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password','password', 'required|trim|xss_clean');

        if($this->form_validation->run() == FALSE){
            $this->load->view('login');
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $username;
            $pass = md5($password);

            $cek = $this->Login_model->cek($user, $pass);

            if($cek->num_rows() > 0){
                foreach($cek->result() as $qad){
                    $sess_data['username'] = $qad->username;
                    $this->session->set_userdata($sess_data);
                }
                redirect(base_url('admin'));
            }else{
                $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukka salah</br>');
                redirect(base_url('login'));
            }
        }
    }
}
<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Login_model extends CI_Model{
    function cek($username, $password){
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        return $this->db->get('admin');
    }

    function getLoginData($user, $pass){
        $u = $user;
        $p = md5($pass);
        $query_cekLogin = $this->db->get_where('admin',array('username' => $u, 'password' => $p));
        if(count($query_cekLogin->result()) > 0){
            foreach($query_cekLogin->result() as $qck){
                foreach($query_cekLogin->result() as $qad){
                    $sess_data['logged_in'] = TRUE;
                    $sess_data['username'] = $qad->username;
                    $sess_data['password'] = $qad->password;
                    $this->session->set_userdata($sess_data);
                }
                redirect('admin');
            }
        }else{
            $this->session->set_flashdata('result_login','<br>Username atau Password yang anda masukkan salah</br>.');
            header('location:' . base_url() . 'login');
        }
    }
}

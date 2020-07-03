<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Databarang extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
        }
        $this->load->model('DataBarang_model');
    }
    function index(){
        $this->load->view("header");
        $this->load->view("sidebar");
        $this->load->view("databarang");
    }
    function ajax_list(){
        $this->load->model('DataBarang_model','databarang');
        $list = $this->DataBarang_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $li){
           $no++;
           $row = array();
           $row[] = $no;
           $row[] = $li->kodeBarang;
           $row[] = $li->namaBarang;
           $row[] = '<div style="text-align:center">
                      <button onClick="editBarang('."'$li->idBarang'".')" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-xs btn-danger" onClick="hapusBarang('."'$li->idBarang'".')"><i class="fa fa-trash"></i></button>
                    </div>';
           $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'],
          "recordsTotal" => $this->databarang->count_all(),
          "recordsFiltered" => $this->databarang->count_filtered(),
          "data" => $data
        );
        echo json_encode($output);
    }
    function editBarang($id){
        $data = $this->DataBarang_model->getById($id);
        echo json_encode($data);
    }
    function updateBarang(){
        $data = array(
            'kodeBarang' => $this->input->post('kodeBarang'),
            'namaBarang' => $this->input->post('namaBarang')
        );
        $this->DataBarang_model->update(array('idBarang' => $this->input->post('idBarang')),$data);
        echo json_encode(array("status" => TRUE));
    }
    function hapusBarang($id){
        $this->DataBarang_model->deleteById($id);
        echo json_encode(array("status" => TRUE));
    }
}
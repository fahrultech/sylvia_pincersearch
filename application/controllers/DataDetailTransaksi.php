<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataDetailTransaksi extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
        }
        $this->load->model('DataDetailTransaksi_model');
    }
    function index(){
        $this->load->view("header");
        $this->load->view("sidebar");
        $this->load->view("datadetailtransaksi");
    }
    function ajax_list(){
        $this->load->model('DataDetailTransaksi_model','datatransaksi');
        $list = $this->DataDetailTransaksi_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $li){
           $no++;
           $row = array();
           $row[] = $no;
           $row[] = tgl_indo($li->tanggal);
           $row[] = $li->noInvoice;
           $row[] = $li->kodeBarang;
           $row[] = $li->namaBarang;
           $row[] = '<div style="text-align:center">
                      <button onClick="editAlatTangkap('."'$li->idDetailTransaksi'".')" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-xs btn-danger" onClick="hapusAlatTangkap('."'$li->idDetailTransaksi'".')"><i class="fa fa-trash"></i></button>
                    </div>';
           $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'],
          //"recordsTotal" => $this->kecamatan->count_all(),
          "recordsFiltered" => $this->datatransaksi->count_filtered(),
          "data" => $data
        );
        echo json_encode($output);
    }
}
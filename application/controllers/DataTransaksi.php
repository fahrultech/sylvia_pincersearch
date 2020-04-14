<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataTransaksi extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
        }
        $this->load->model('DataTransaksi_model');
        $this->load->model('DataDetailTransaksi_model');
    }
    function index(){
        $this->load->view("header");
        $this->load->view("sidebar");
        $this->load->view("datatransaksi");
    }
    function ajax_list(){
        $this->load->model('DataTransaksi_model','datatransaksi');
        $list = $this->DataTransaksi_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $li){
           $no++;
           $row = array();
           $row[] = $no;
           $row[] = tgl_indo($li->tanggal);
           $row[] = $li->noInvoice;
           $row[] = '<div style="text-align:center">
                      <button onClick="editTransaksi('."'$li->idTransaksi'".')" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-xs btn-danger" onClick="hapusTransaksi('."'$li->idTransaksi'".')"><i class="fa fa-trash"></i></button>
                    </div>';
           $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'],
          "recordsFiltered" => $this->datatransaksi->count_filtered(),
          "data" => $data
        );
        echo json_encode($output);
    }
    function editTransaksi($id){
        $data = $this->DataTransaksi_model->getById($id);
        echo json_encode($data);
    }
    function updateTransaksi(){
        $data = array(
            'tanggal' => $this->input->post('tanggal'),
            'noInvoice' => $this->input->post('noInvoice')
        );
        $this->DataTransaksi_model->update(array('idTransaksi' => $this->input->post('idTransaksi')),$data);
        echo json_encode(array("status" => TRUE));
    }
    function hapusTransaksi($id){
        $noinvoice = $this->DataTransaksi_model->getInvoiceNo($id);
        $this->DataDetailTransaksi_model->deleteByNoInvoice($noinvoice[0]->noInvoice);
        $this->DataTransaksi_model->deleteById($id);
        echo json_encode(array("status" => TRUE));
    }
}
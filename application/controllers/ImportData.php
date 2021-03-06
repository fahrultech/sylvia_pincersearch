<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importdata extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('ImportData_model');
        $this->load->library('excel');
        if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
    }
    function index(){
        $this->load->view("header");
        $this->load->view("sidebar");
        $this->load->view("importdata");
        $this->load->view("footer");
    }

    //untuk filter atau menghapus nilai yang sama pada array
    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
       
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
    function import(){
        if(isset($_FILES["file"]["name"]))
        {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach($object->getWorkSheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $date = strtotime($worksheet->getCellByColumnAndRow(0, $row)->getFormattedValue());
                    //echo $date."</br>";

                    $noinvoice = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $kodebarang = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $namabarang = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $tanggal = date('Y-m-d',$date);
                    if($kodebarang != null){
                        $dataBarang[] = array(
                            'kodeBarang' => $kodebarang,
                            'namaBarang' => $namabarang
                        );
                    }
                    if($noinvoice != null){
                        $headerTransaksi[] = array(
                            'tanggal' => $tanggal,
                            'noInvoice' => $noinvoice
                        );
                    }
                    if($noinvoice != null){
                        $detailTransaksi[] = array(
                            'noInvoice' => $noinvoice,
                            'kodeBarang' => $kodebarang,
                            'tanggal' => $tanggal
                        );
                    }
                }
            }
            $dataBarang = $this->unique_multidim_array($dataBarang,'kodeBarang');
            $headerTransaksi = $this->unique_multidim_array($headerTransaksi,'noInvoice');
            $jumlahTransaksi = $this->ImportData_model->insertHeaderTransaksi($headerTransaksi);
            $this->ImportData_model->insertDetailTransaksi($detailTransaksi);
            $jumlahBarang = $this->ImportData_model->insertBarang($dataBarang);
            echo json_encode(array($jumlahBarang,$jumlahTransaksi));
        }
    }
}
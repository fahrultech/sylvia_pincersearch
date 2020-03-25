<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganPincerSearch extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
        }
        $this->load->model('PerhitunganPincerSearch_model');
        $this->load->model('DataBarang_model');
    }
    function index(){
        $this->load->view("header");
        $this->load->view("sidebar");
        $this->load->view("perhitunganpincersearch");
        $this->load->view("footer");
    }
    function getAllItem(){
        $data = $this->PerhitunganPincerSearch_model->getAll();
        echo json_encode($data);
    }
    function getCandidateSetOne(){
      
    }
    function getByDate(){
        $tglawal = $this->input->post('tglawal');
        $tglakhir = $this->input->post('tglakhir');
        $dataDetailTransaksi = $this->PerhitunganPincerSearch_model->getDetailTransactionByDate($tglawal, $tglakhir);
        $detailTransaksiArray = array();
        $tempDataBarang = array();
        $tempC2Data = array();
        $dataC1 = array();
        $dataC2 = array();
        $no=0;
        foreach($dataDetailTransaksi as $ddt){
          $row = array();
          $row["noInvoice"] = $ddt->noInvoice;
          $row["kodeBarang"] = [$ddt->kodeBarang];
          $idx = array_search($ddt->noInvoice,array_column($detailTransaksiArray,'noInvoice')); 
          if($idx == false){
            $detailTransaksiArray[] = $row;
          }else{
            array_push($detailTransaksiArray[$idx]['kodeBarang'],$ddt->kodeBarang);
          }
          $tempDataBarang[] = $ddt->kodeBarang;
          $no++;
        }
        $tempDataBarang = array_unique($tempDataBarang);
        foreach($tempDataBarang as $tmp){
          $count =0;
          foreach($dataDetailTransaksi as $ddt){
            if($tmp === $ddt->kodeBarang){
               $count++;
            }
          }
          if($count > 3){
            $dataC1[] = array("kodebarang" => $tmp, "jumlah" => $count);
          }
        }
        for($i=0;$i<count($dataC1)-1;$i++){
          for($j=$i+1;$j<count($dataC1);$j++){
            $row = array();
            $row[]= $dataC1[$i]['kodebarang'];
            $row[]= $dataC1[$j]['kodebarang'];
            $tempC2Data[] = $row;
          }
        }
        for($i=0;$i<count($tempC2Data);$i++){
          $count = 0;
          $row = array();
          for($j=0;$j<count($detailTransaksiArray);$j++){
            $ct = count(array_diff($tempC2Data[$i],$detailTransaksiArray[$j]["kodeBarang"]));
            if($ct === 0){
              $count++;
            }
          }
          if($count > 2){
            $row["item"] = $tempC2Data[$i];
            $row["jumlah"] = $count;
            $dataC2[] = $row;
          }
        }
        $dataBarang = $this->DataBarang_model->getAll();
        echo json_encode($dataC2);
    }
    function getMFCS(){
      $MFCS = [[1,2,3,4,5,6]];
      $iF = [[1,6],[3,6]];
      $deleteMFCS = array();
      
      for($i=0;$i<count($iF);$i++){
        for($j=0;$j<count($MFCS);$j++){
          if(count(array_diff($iF[$i],$MFCS[$j])) == 0){
            $tempMFCS = array();
            $tempMFCS = $MFCS[$j];
            array_splice($MFCS,$j,1);
            for($k=0;$k<count($iF[$i]);$k++){
               $key = array_search($iF[$i][$k], $tempMFCS);
               $st = array();
               $st = $tempMFCS;
               array_splice($st,$key,1);
               if(count($MFCS) == 0){
                  $MFCS[] = $st;
               }else{
                 for($l=0;$l<count($MFCS);$l++){
                  if(count(array_diff($st,$MFCS[$l])) !== 0){
                    $MFCS[] = $st;
                  }else{
                    if(count($st) != count($MFCS[$l])){
                      $deleteMFCS[] = $st;
                    }
                  }
                 }
               }
            }
          }
        }
      }
      function removeMFCSItem($rm,$mfcs){
         for($i=0;$i<count($rm);$i++){
           $k = array_search($rm[$i],$mfcs);
           array_splice($mfcs,$k,1);
         }
         return $mfcs;
      }
      $MFCS = removeMFCSItem($deleteMFCS,$MFCS);
      for($i=0;$i<count($MFCS);$i++){
        for($j=0;$j<count($MFCS[$i]);$j++){
          echo $MFCS[$i][$j];
        }
        echo "</br>";
      }
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganPincerSearch extends CI_Controller{
    private $mfcs = array();
    private $mfs = array();
    private $c1 = array();
    private $infrequent = array();
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
    function joinProcedure($db=array()){
      $dataItems = array();
      for($i=0;$i<count($db)-1;$i++){
        for($j=$i+1;$j<count($db);$j++){
          if(count(array_intersect($db[$i],$db[$j])) === $freq-1){
           $dataItems[] = $this->removeDupplicateArray(array_merge($db[$i],$b[$j]));
          }
       }
      }
      return $this->removeDupplicateMultiDimArray($dataItems);
    }
    function frequentUpdate($frequent,$initDataBarang = array(),$datatransaksi,$minsupport,$last=array()){
       $dataC = array();
       $nextDataBarang = array();
       $infrequentItems = array();
       for($i=0;$i<count($initDataBarang);$i++){
        $row = array();
        $count = 0;
        for($j=0;$j<count($datatransaksi);$j++){
          $ct = count(array_diff($initDataBarang[$i],$datatransaksi[$j]["kodeBarang"]));
          if($ct === 0){
            $count++;
          }
        }
        if($count >= $minsupport){
          $row[] = $initDataBarang[$i];
          $row[] = $count;
          $dataC[] = $row;
          $nextDataBarang[] = $initDataBarang[$i];
        }else{
          $rw = array();
          $rw[] = $initDataBarang[$i];
          $infrequentItems[] = $initDataBarang[$i];
        }
       }
       $res = $this->checkNextFrequent($frequent,$nextDataBarang,$datatransaksi,$minsupport);
       $ses = $this->getMFCS($this->infrequent);
       return $res;
      //  if(count($res) === 0){
      //   return $last;
      //  }else{
      //     $last = $res;
      //     $nextD = array();
      //     foreach($res as $r){
      //       $nextD[] = $r[0];
      //     }
      //     $frequent +=1;
      //   return $this->frequentUpdate($frequent,$nextD,$datatransaksi,$minsupport,$last); 
      //  }
    }
    function checkNextFrequent($freq,$dataBarang, $datatransaksi,$minsupport){
       $dataItems = array();
       $newDataItems = array();
       $nextFrequentData = array();
       $infrequentItems = array();
       for($i=0;$i<count($dataBarang)-1;$i++){
         for($j=$i+1;$j<count($dataBarang);$j++){
           if(count(array_intersect($dataBarang[$i],$dataBarang[$j])) === $freq-1){
            $dataItems[] = $this->removeDupplicateArray(array_merge($dataBarang[$i],$dataBarang[$j]));
           }
        }
       }
       $newDataItems = $this->removeDupplicateMultiDimArray($dataItems);
       for($i=0;$i<count($newDataItems);$i++){
         if(count($newDataItems[$i])>1){
          $count = 0;
          for($j=0;$j<count($datatransaksi);$j++){
            $ct =  count(array_diff($newDataItems[$i],$datatransaksi[$j]["kodeBarang"]));
            if($ct === 0){
               $count++;
            }
         }
         if($count >= $minsupport){
           $row = array();
           $row[] = $newDataItems[$i];
           $row[] = $count;
           $nextFrequentData[] = $row;
          }else{
            $infrequentItems[] =$newDataItems[$i];
          }
         }
       }
       
       $this->infrequent = $this->removeDupplicateMultiDimArray($infrequentItems); 
       return $this->removeDupplicateMultiDimArray($infrequentItems);
       //return $this->removeMultiDupplicateMultiDimArray($infrequentItems);
    }
    function getByDate(){
        $tglawal = $this->input->post('tglawal');
        $tglakhir = $this->input->post('tglakhir');
        $minsupport = $this->input->post('minsupport');
        $dataDetailTransaksi = $this->PerhitunganPincerSearch_model->getDetailTransactionByDate($tglawal, $tglakhir);
        $detailTransaksiArray = array();
        $tempmfcs = array();
        $no=0;
        foreach($dataDetailTransaksi as $ddt){
          $row = array();
          $row["noInvoice"] = $ddt->noInvoice;
          $row["kodeBarang"] = [$ddt->kodeBarang];
          $idx = array_search($ddt->noInvoice,array_column($detailTransaksiArray,'noInvoice')); 
          if($idx === false){
            $detailTransaksiArray[] = $row;
          }else{
            array_push($detailTransaksiArray[$idx]['kodeBarang'],$ddt->kodeBarang);
          }
          $r=array();
          $r[]=$ddt->kodeBarang;
          $tempmfcs[] = $ddt->kodeBarang;
          $this->c1[] = $r;
          $no++;
        }
        
        $this->mfcs[] = $this->removeDupplicateArray($tempmfcs);
        echo json_encode($this->frequentUpdate($frequent=1,$this->removeDupplicateMultiDimArray($this->c1),$detailTransaksiArray,$minsupport));
    }
    function removeDupplicateArray($db=array()){
      for($i=0;$i<count($db)-1;$i++){
        for($j=$i+1;$j<count($db);$j++){
          if($db[$i] === $db[$j]){
            array_splice($db,$j,1);
          }
        }
      }
      return $db;
    }
    function removeDupplicateMultiDimArray($db=array()){
      for($i=0;$i<count($db)-1;$i++){
        for($j=$i+1;$j<count($db);$j++){
           if(count(array_diff($db[$i],$db[$j]))===0){
            array_splice($db,$j,1); 
           }
        }
      }
      return $db;
    }
    function removeMultiDupplicateMultiDimArray($db=array()){
      for($i=0;$i<count($db)-1;$i++){
        for($j=$i+1;$j<count($db);$j++){
           if(count(array_diff($db[$i][0],$db[$j][0]))===0){
            array_splice($db,$j,1); 
           }
        }
      }
      return $db;
    }
    function getMFCS($iF){
      $MFCS = array();
      $MFCS = $this->mfcs;
      //$iFf = [[1,6],[3,6]];
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
              //  print_r($st);
              //  echo "------";
               $MFCS[] = $st;
              //  if(count($MFCS) == 0){
              //     $MFCS[] = $st;
              //  }else{
              //    for($l=0;$l<count($MFCS);$l++){
              //     if(count(array_diff($st,$MFCS[$l])) !== 0){
              //       $MFCS[] = $st;
              //     }else{
              //       if(count($st) != count($MFCS[$l])){
              //         $deleteMFCS[] = $st;
              //       }
              //     }
              //    }
              //  }
            }
            print_r($MFCS);
            echo "------";
          }
        }
      }
      // function removeMFCSItem($rm,$mfcs){
      //    for($i=0;$i<count($rm);$i++){
      //      $k = array_search($rm[$i],$mfcs);
      //      array_splice($mfcs,$k,1);
      //    }
      //    return $mfcs;
      // }
      // $MFCS = removeMFCSItem($deleteMFCS,$MFCS);
      return $this->removeDupplicateMultiDimArray($MFCS);
    }
}
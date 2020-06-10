<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganPincerSearch extends CI_Controller{
    private $mfcs = array();
    private $mfs = array();
    private $c1 = array();
    private $infrequent = array();
    private $totalTransaksi;
    private $datatransaksi;
    private $sosupport; 
    private $minConfidence;
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
    function ss($dat){
        $cow = array();
        foreach($dat as $dt){
           $row = array();
           foreach($dt as $d){
            $db = $this->DataBarang_model->getByKodeBarang($d);
            $row[] = $db->namaBarang;
           }
           $cow[] = $row;
        }
        return $cow;
    }
    function getDetailBarang($res){
      $data = array();
      $no=0;
      foreach($res as $rr){  
        $cow = array();
        foreach($rr[0] as $r){
          $row = array();
          for($i=0;$i<count($r);$i++){
            $db = $this->DataBarang_model->getByKodeBarang($r[$i]);
            $row[] = $db->namaBarang;
          }
        $cow[] = $row;
        }
        $data[] = $cow;
        array_splice($res[$no],0,1,$data[$no]);
        $no++;
      }
      return $res;
   }
    function getByDate(){
        $tglawal = $this->input->post('tglawal');
        $tglakhir = $this->input->post('tglakhir');
        $minsupport = $this->input->post('minsupport');
        $maxitem = $this->input->post('maxitem');
        $this->minConfidence = $this->input->post('minconfidence');
        $dataDetailTransaksi = $this->PerhitunganPincerSearch_model->getDetailTransactionByDateAndCount($tglawal, $tglakhir,$maxitem);
        $detailTransaksiArray = array();
        $transaksi = array();
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
        // $readyDelete = array();
        // for($i=0;$i<count($detailTransaksiArray);$i++){
        //   if(count($detailTransaksiArray[$i]["kodeBarang"]) < $maxitem){
        //     $readyDelete[] =$i;
        //   }
        // }
        // for($i=0;$i<count($readyDelete);$i++){
        //   unset($detailTransaksiArray[$readyDelete[$i]]);
        // }
        // foreach($detailTransaksiArray as $dt){
        //   foreach($dt["kodeBarang"] as $kd){
        //     $r=array();
        //     $r[]=$kd;
        //     $tempmfcs[] = $kd;
        //     $this->c1[] = $r;
        //   }
        // }
        foreach($detailTransaksiArray as $ddt){
          $transaksi[] = $ddt["kodeBarang"];
        }
        $this->totalTransaksi = count($detailTransaksiArray);
        $this->datatransaksi = $detailTransaksiArray;
        $this->mfcs[] = $this->removeDupplicateArray($tempmfcs);
        $this->sosupport = ($this->totalTransaksi * $minsupport)/100;
        echo json_encode($this->running($this->mfcs,$transaksi,$this->removeDupplicateArray($this->c1)));
    }
    function removeDupplicateArray($db){
      $removeKeys = array();
      for($i=0;$i<count($db)-1;$i++){
        for($j=$i+1;$j<count($db);$j++){
          if($db[$i] === $db[$j]){
            $removeKeys[] = $j;
          }
        }
      }
      for($i=0;$i<count($removeKeys);$i++){
           unset($db[$removeKeys[$i]]);
      }
      return array_values($db);
    }
    function removeDupplicateArrayNew($db=array()){
      for($i=0;$i<count($db)-1;$i++){
        for($j=$i+1;$j<count($db);$j++){
          if(count(array_diff($db[$i],$db[$j])) == 0){
            array_splice($db,$j,1);
          }
        }
      }
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

    // Fungsi utama untuk melakukan algoritma pincersearch
    function running($mfcs=array(),$db=array(),$cdata=array()){
      // Inisialisasi variabel-variabel yang dibutuhkan dalam proses
      $i=0;
      $mfs = array();
      $log = array();
      $log = [
        array("k" => 0, 
          "frequent" => [], 
          "infrequent" => [], 
          "mfcs" => count($mfcs) !== 0 ? $this->ss($mfcs) : $mfcs, 
          "mfs" => [], 
          "cdata" => count($cdata) !== 0 ? $this->ss($cdata) : $cdata)];
      while(count($cdata) > 0){
        $pass = array();
        $pass["k"] = $i+1;
        $frequent = $this->getFrequentItems($cdata,$db);
        $pass["frequent"] = count($frequent) !== 0 ? $this->ss($frequent) : $frequent;
        $infrequent = $this->getInFrequentItems($cdata,$db);
        $pass["infrequent"] = count($infrequent) !== 0 ? $this->ss($infrequent) : $infrequent;
        $mfs = $this->getMFS($mfcs,$frequent);
        $pass["mfs"] = count($mfs) !== 0 ? $this->ss($mfs) : $mfs;
        $tempFreq = $frequent;
        count($mfs) > 0 ? $frequent = $this->lprune($frequent,$mfs) : $frequent = $frequent;
        $mfcs = $this->removeMFCSSubset($this->sortByCount($this->getMFCS($infrequent,$mfcs)));
        $pass["mfcs"] = count($mfcs) !== 0 ? $this->ss($mfcs) : $mfcs;
        $cdata = $this->removeMFCSSubset($this->joinData($frequent));
        if(count($tempFreq) !== count($frequent)){
          $this->recovery($frequent,$mfs);
        }
        count($mfs) > 0 ? $cdata = $this->newPrune($frequent,$mfcs) : $cdata;
        $pass["cdata"] = count($cdata) !== 0 ? $this->ss($cdata) : $cdata;
        array_push($log,$pass);
        $i++;
      }
      $ret = [$log, $this->getDetailBarang($this->countSupport($this->getAssociationRule($mfs)))];
      return $ret;
    }
    function countSupport($data){
       $hasil = array();
       foreach($data as $dt){
         $newData = array_merge($dt[0],$dt[1]);
         $supportxy = 0;
         $supportx = 0;
         $supporty = 0;
         foreach($this->datatransaksi as $nd){
          if(count(array_diff($newData,$nd["kodeBarang"])) === 0){
            $supportxy++;
          }
          if(count(array_diff($dt[0],$nd["kodeBarang"])) === 0){
            $supportx++;
          }
          if(count(array_diff($dt[1],$nd["kodeBarang"])) === 0){
            $supporty++;
          }
         }
         $supportXYPercentage = round(($supportxy/$this->totalTransaksi)*100,1);
         $supportXPercentage = round(($supportx/$this->totalTransaksi)*100,1);
         $supportYPercentage = round(($supporty/$this->totalTransaksi)*100,1);
         $confidence = round(($supportxy/$supportx)*100,1);
         $liftRatio = round($confidence/$this->minConfidence,2);
         if($confidence >= $this->minConfidence){
          $hasil[] = [$dt,$supportXYPercentage,$supportXPercentage,$confidence,$supportYPercentage,$liftRatio];
         }
       }
       return $hasil;
    }
    function lprune($frequent,$mfs){
      for($i=0;$i<count($frequent);$i++){
        for($j=0;$j<count($mfs);$j++){
          if(count(array_diff($frequent[$i],$mfs[$j])) === 0){
            array_splice($frequent,$i,1);
          }
        }
      }
      return $frequent;
    }
    function recovery($frequent,$mfs){
      $hasil = array();
      foreach($mfs as $m){
        $temp = array();
        foreach($frequent as $fr){
          foreach($fr as $f){
            if(in_array($f,$m)){
              if(!in_array($f,$hasil)){
                $temp[] = $f;
              }
            }
          }
        }
        $hasil[] = $temp;
      }
      return $hasil;
    }
    function getFrequentItems($mfcs, $db){
      $frequent = array();
      foreach($mfcs as $m){
        $support = 0;
        $row = array();
        foreach($db as $d){
          $jumlah = count(array_diff($m,$d));
          if($jumlah === 0){
            $support++;
          }
        }
        if($support >= $this->sosupport){
          $frequent[] = $m;
        }
      } 
      return $frequent;
   }
    function getInFrequentItems($mfcs, $db){
      $infrequent = array();
      foreach($mfcs as $m){
        $support = 0;
        $row = array();
        foreach($db as $d){
          $jumlah = count(array_diff($m,$d));
          if($jumlah === 0){
            $support++;
          }
        }
        if($support < $this->sosupport){
          $infrequent[] = $m;
        }
      } 
      return $infrequent;
   }
    function joinData($data=array()){
      $ck = array();
      for($i=0;$i<count($data)-1;$i++){
        for($j=$i+1;$j<count($data);$j++){
          if(count($data[$i]) > 1){
            if(count($data[$i])-count(array_intersect($data[$i],$data[$j])) === 1){
               $ck[] = array_merge($data[$i],array_diff($data[$j],$data[$i]));
            }
          }else{
             $ck[] = array_merge($data[$i],$data[$j]);
          }
        }
      }
    return $this->removeDupplicateResult($ck);
    }
    function removeDupplicateResult($data){
      $tempArray = array();
      for($i=0;$i<count($data)-1;$i++){
        for($j=$i+1;$j<count($data);$j++){
          if(count(array_diff($data[$i],$data[$j])) === 0){
            array_splice($data,$j,1);
          }
        }
      }
      return $data;
    }
    function newPrune($ck,$mfcs){
      $id = array();
       for($i=0;$i<count($ck);$i++){
         $count=0;
         for($j=0;$j<count($mfcs);$j++){
           if(count(array_diff($ck[$i],$mfcs[$j])) !== 0){
             $count++;
           }
         }
         if($count === count($mfcs)){
           $id[] = $i;
         }
       }
       foreach($id as $i){
         unset($ck[$i]);
       }
       return array_values($ck);
    }
    function getMFS($mfcs, $db){
      $mfs = array();
      for($i=0;$i<count($mfcs);$i++){
        for($j=0;$j<count($db);$j++){
          if(count(array_diff($mfcs[$i],$db[$j])) === 0){
            $mfs[] = $mfcs[$i];
          }
        }
      }
      return $mfs;
    }
    function removeMFCSSubset($data){
      for($i=0;$i<count($data)-1;$i++){
        for($j=$i+1;$j<count($data);$j++){
          if(count(array_diff($data[$i],$data[$j])) === 0){
            array_splice($data,$i,1);
          }
        }
      }
      return $data;
    }
    function sortByCount($data){
      $temp = array();
       for($i=0;$i<count($data)-1;$i++){
         for($j=$i+1;$j<count($data);$j++){
           if(count($data[$i])>count($data[$j])){
              $temp = $data[$i];
              $data[$i] = $data[$j];
              $data[$j] = $temp;
           }
         }
       }
       return $data;
    }
    function getMFCS($iF,$MFCS){
      for($i=0;$i<count($iF);$i++){
        for($j=0;$j<count($MFCS);$j++){
          if(count(array_diff($iF[$i],$MFCS[$j])) == 0){
            $tempMFCS = array();
            $tempMFCS = $MFCS[$j];
            array_splice($MFCS,$j,1);
            for($k=0;$k<count($iF[$i]);$k++){
                $st = array();
                $key = array_search($iF[$i][$k], $tempMFCS);
                $st = $tempMFCS;
                array_splice($st,$key,1);
                $MFCS[] = $st;
            }
          }
        }
      }
    return $MFCS;
    }
    function getAssociationRule($dat){
      $hasil = array();
      $no = count($dat)-1;
      foreach($dat as $data){
          if(count($data) === 2){
              for($i=0;$i<count($data);$i++){
                  $cow = array();
                  $cow[] = $data[$i];
                  $hasil[] = [$cow,array_values(array_diff($data,$cow))]; 
              }
          }
          else if(count($data) === 3){
              for($i=0;$i<count($data);$i++){
                  $cow = array();
                  $cow[] = $data[$i];
                  $hasil[] = [$cow,array_values(array_diff($data,$cow))]; 
                  for($j=$i+1;$j<count($data);$j++){
                      $row = array();
                      $row[] = $data[$i];
                      $row[] = $data[$j];
                      $hasil[] = [$row,array_values(array_diff($data,$row))];
                      $no--;
                  }
              }
          }else if(count($data) === 4){
              for($i=0;$i<count($data);$i++){
                  $cow = array();
                  $cow[] = $data[$i];
                  $hasil[] = [$cow,array_values(array_diff($data,$cow))]; 
                  for($j=$i+1;$j<count($data);$j++){
                      $jow = array();
                      $jow[] = $data[$i];
                      $jow[] = $data[$j];
                      $hasil[] = [$jow,array_values(array_diff($data,$jow))];
                      for($k=$j+1;$k<count($data);$k++){
                          $row = array();
                          $row[] = $data[$i];
                          $row[] = $data[$j];
                          $row[] = $data[$k];
                          $hasil[] = [$row,array_values(array_diff($data,$row))];
                          $no--;
                      }
                  }
              }
          }
      }
      
    return $this->sortByNum($hasil);
  }
  function sortByNum($data){
    for($i=0;$i<count($data)-1;$i++){
        for($j=$i+1;$j<count($data);$j++){
            if(!is_array($data[$i][0])){
             $temp = $data[$i];
             $data[$i] = $data[$j];
             $data[$j] = $temp;
            }else if(is_array($data[$i][0]) && is_array($data[$j][0])){
                if(count($data[$i][0]) < count($data[$j][0])){
                 $temp = $data[$i];
                 $data[$i] = $data[$j];
                 $data[$j] = $temp;
                }
            }
        }
    }
    return $data;
 }
}
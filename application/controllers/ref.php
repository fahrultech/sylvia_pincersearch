<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <?php
$mfcs = [["A Yun Roti Bolu","Giv Pearl","Kopi Bubuk SP","Roma Marie","Dettol Soap"]];
$c1 = [["A Yun Roti Bolu"],["Giv Pearl"],["Kopi Bubuk SP"],["Roma Marie"],["Dettol Soap"]];
$db = [
 ["A Yun Roti Bolu", "Giv Pearl", "Kopi Bubuk SP"],
 ["Kopi Bubuk SP", "Roma Marie"],
 ["Giv Pearl", "A Yun Roti Bolu"],
 ["Kopi Bubuk SP", "Dettol Soap"],
 ["Giv Pearl", "Dettol Soap"]
];

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
     if($support >= 1){
       $row[] = $m;
       $row[] = $support;
       $frequent[] = $row;
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
     if($support === 0){
       $infrequent[] = $m;
     }
   } 
   return $infrequent;
}
function joinData($data){
  $ck = array();
  for($i=0;$i<count($data)-1;$i++){
    for($j=$i+1;$j<count($data);$j++){
      if(count($data[$i][0] > 1)){
         $c = count(array_diff($data[$i][0],$data[$j][0]));
         if($c === 1){
           $ck[] = array_merge($data[$i][0],$data[$j][0]);
         }
      }else{
         $ck[] = array_merge($data[$i][0],$data[$j][0]);
      }
    }
  }
  return removeDupplicateResult(removeDupplicateMultiDimArray($ck));
}
function removeDupplicateResult($data){
  for($i=0;$i<count($data)-1;$i++){
    for($j=$i+1;$j<count($data);$j++){
      if(count(array_diff($data[$i],$data[$j])) === 0){
        array_splice($data,$j,1);
      }
    }
  }
  return $data;
}
$satu = joinData(getFrequentItems($c1,$db));
$dua = joinData(getFrequentItems($satu,$db));
$frequentk1 = getFrequentItems($satu,$db);
$infrequentk1 = getInFrequentItems($satu,$db);

print_r(removeMFCSSubset(sortByCount(getMFCS($infrequentk1,$mfcs))));

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
  $no=0;
  foreach($db as $d){
    for($i=0;$i<count($d)-1;$i++){
      for($j=$i+1;$j<count($d);$j++){
        if($d[$i] === $d[$j]){
          array_splice($db[$no],$j,1);
        }
      }
    }
  $no++;
  }
  return $db;
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
       if(count($data[$i]>count($data[$j]))){
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
?>
  </body>
</html>
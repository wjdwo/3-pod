<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT']; 
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/ajaxCalledPageInclude.php');
?>
<?php
  $cmdArr2 = array(
    "command" => "listAvailableProductTypes",
    "zoneid" => $_POST['zoneid'],
    "apikey"  => API_KEY
  );
   $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
  $result2 = callCommand($URL, $cmdArr2, SECERET_KEY);
  $type =array();
  for($i=0; $i<(int)$result2['count']; $i++){
    if($result2['producttypes'][$i]['product'] != $_POST['product']){
      continue;
    }
    if($result2['producttypes'][$i]['templateid'] != $_POST['templateid']){
      continue;
    }
    if($result2['producttypes'][$i]['serviceofferingid'] != $_POST['serviceofferingid']){
      continue;
    }
    if(!isset($result2['producttypes'][$i]['diskofferingid'])){
      continue;
    }
    if(in_array($result2['producttypes'][$i]['diskofferingid'],$type)){
      continue;
    }else if(is_string($result2['producttypes'][$i]['diskofferingid'])){
      array_push($type,$result2['producttypes'][$i]['diskofferingdesc']);
      array_push($type,$result2['producttypes'][$i]['diskofferingid']);
    }
  }
  for($i = 0; $i < count($type); $i++){
    echo "<option>".$type[$i];
  }
  
?>

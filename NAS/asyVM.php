<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/ajaxCalledPageInclude.php');

  $cmdArr2 = array(
    "command" => "listVirtualMachines",
    "zoneid" => $_POST['zoneid'],
    "apikey"  => API_KEY
  );
   $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

  $result = callCommand($URL, $cmdArr2, SECERET_KEY);

  $type =array();
  if(isset($result['count']) != true) exit;
  $result_num = $result['count'];
  $result = $result['virtualmachine'];

  for($i=0; $i<$result_num; $i++){
    if((int)$result_num == 1 ) {
      $temp = $result;
    }else {
      $temp = $result[$i];
    }
    if($temp['zoneid'] == $_POST['zoneid']) {
      array_push($type,$temp['displayname']);
      array_push($type,$temp['id']);
    }
  }
  for($i = 0; $i < count($type); $i++){
    echo $type[$i]."<option>";
  }
  
?>

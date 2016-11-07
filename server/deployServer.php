<?php
@session_start();
$server_root_path = $_SERVER['DOCUMENT_ROOT']; //ini_set('include_path',$server_root_path);
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/asynCommandPageInclude.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>

<script>
	var loca = function(){
		location.replace('myServer.php');
	}
	var err_info = function(){
		history.back();
	}
</script>
</head>
<body>
<?php

$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
$cmdArr = array(
  "command" => "deployVirtualMachine",
  "serviceofferingid" => $_POST['serviceofferingid'],
  "templateid" => $_POST['templateid'],
  "zoneid" => $_POST['zoneid'],
  "displayname" => $_POST['displayname'],
  "usageplantype" =>  $_POST['usageplantype'],
  "apikey" => API_KEY
);
if ($_POST['diskofferingid'] != "rootonly"){
  $cmdArr["diskofferingid"] = $_POST['diskofferingid'];
}
set_time_limit(60000);

$result = callCommand($URL, $cmdArr, SECERET_KEY);

$jobId = $result["jobid"];
echo $jobId;
if(session_push('processID',$result['jobid'])==true){
	echo "<script>Confirm.render('Server','신청이 완료 되었습니다',loca,'','no')</script>";
} else {
	echo "<script>Confirm.render('Server','오류가 발생했습니다!',err_info,'','no')</script>";
}

?>
<?php
    
?>

</body>
</html>
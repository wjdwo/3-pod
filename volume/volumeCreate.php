<?php
@session_start();
$server_root_path = $_SERVER['DOCUMENT_ROOT']; 
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/asynCommandPageInclude.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<script>
	var loca = function(){
		location.replace('listVolume.php');
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
  "command" => "createVolume",
  "zoneid" => $_POST['zoneid'],
  "diskofferingid" => $_POST['diskofferingid'],
  "name" => $_POST['name'],
  "usageplantype" =>  $_POST['usageplantype'],
  "apikey" => API_KEY
);
$result = callCommand($URL, $cmdArr, SECERET_KEY);
set_time_limit(600);

$jobId = $result["jobid"];
if(session_push('processID',$result['jobid'])==true){
	echo "<script>Confirm.render('Volume','신청이 완료 되었습니다',loca,'','no')</script>";
} else {
	echo "<script>Confirm.render('Volume','오류가 발생했습니다!',err_info,'','no')</script>";

}
?>

</body>
</html>
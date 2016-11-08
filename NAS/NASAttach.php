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
		location.replace('listNAS.php');
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
  "command" => "addNicToVirtualMachine",
  "networkid" => $_POST['networkid'],
  "virtualmachineid" => $_POST['virtualmachineid'],
  "apikey" => API_KEY
);


$result = callCommand($URL, $cmdArr, SECERET_KEY);
set_time_limit(6000);
if(session_push('processID',$result['jobid'])){
	echo "<script>Confirm.render('NAS','서버 연결 신청이 완료 되었습니다',loca,'','no')</script>";
} else {
	echo "<script>Confirm.render('NAS','오류가 발생했습니다!<br>NAS 타입과 Server타입이 맞는지 확인 해주세요.',err_info,'','no')</script>";
}

?>
<?php
    
?>

</body>
</html>
<?php
@session_start();
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/asynCommandPageInclude.php');
?>

<!DOCTYPE>
<html>
<head>

<meta charset="utf-8"/>
<script>
	var loca = function(){
		location.replace('listPublicIP.php');
	}
	var err_info = function(){
		history.back();
	}
</script>
<meta charset="utf-8"/>
</head><body>
<?php

 $cmdArr = array (
    "command" => "deletePortForwardingRule",
    "id" => $_POST['id'],
    "apikey" => API_KEY
 );

 $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
 $result = callCommand($URL, $cmdArr, SECERET_KEY);

set_time_limit(600);
$jobId = $result["jobid"];
echo $jobId;

?>
<br/>
<?php
  if(session_push('processID',$result['jobid'])){
  	echo "<script>Confirm.render('Port Forwarding','삭제 신청이 완료 되었습니다',loca,'','no')</script>";
  }else{
  	echo "<script>Confirm.render('Port Forwarding','오류가 발생했습니다!',err_info,'','no')</script>";
  }
?>
</body>
</html>
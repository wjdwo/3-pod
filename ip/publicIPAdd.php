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
</head>
<script>
  var loca = function(){
    location.replace('listPublicIP.php');
  }
  var err_info = function(){
    history.back();
  }
</script>
<body>
<?php
  if($_POST['zoneid']==""){
    echo "<script>Confirm.render('IP','지역을 다시 설정 해주세요.',err_info,'','no')</script>";
  	exit;
  }
  if($_POST['usageplantype']==""){
    echo "<script>Confirm.render('IP','요금제 설정을 다시 설정 해주세요.',err_info,'','no')</script>";
  	exit;
  }
 $cmdArr = array (
    "command" => "associateIpAddress",
    "zoneid" => $_POST['zoneid'],
    "usageplantype" => $_POST['usageplantype'],
    "apikey" => API_KEY
 );
 $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
 $result = callCommand($URL, $cmdArr, SECERET_KEY);
set_time_limit(600);
$jobId = $result["jobid"];
echo $jobId;

?>
<br/>
<script src="asy.js"></script>

<?php

if(session_push('processID',$result['jobid'])){
  echo "<script>Confirm.render('IP','신청이 완료 되었습니다',loca,'','no')</script>";

} else {
  echo "<script>Confirm.render('IP','오류가 발생했습니다!',err_info,'','no')</script>";
}

?>
</body>
</html>
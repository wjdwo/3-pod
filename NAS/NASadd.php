<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/nonAsynCommandPageInclude.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<script>
    var loca = function(){
      location.replace('listNAS.php');
    }
    var err_info = function(err){
      if(err.match('account')) {
        location.replace('cifsAccount.php');
      } else {
        history.back();
      }
    }
</script>
</head>
<body>
<?php

$URL_NAS = "https://api.ucloudbiz.olleh.com/nas/v1/client/api?";
if($_POST['totalsize']==""){
	$_POST['totalsize'] = '1000';
} else {
	$_POST['totalsize'] = (int)$_POST['totalsize'] + 1000;
}
$cmdArr = array(
  "command" => "addVolume",
  "name" => $_POST['name'],
  "path" => $_POST['path'],
  "zoneid" => $_POST['zoneid'],
  "totalsize" => $_POST['totalsize'], 
  "volumetype" => $_POST['volumetype'],
  "usageplantype" =>  $_POST['usageplantype'],
  "apikey" => API_KEY
);
$result = callCommand($URL_NAS, $cmdArr, SECERET_KEY);
set_time_limit(6000);
if($result['status']=='error') {
  echo "<script>Confirm.render('NAS','".$result['errortext']."',err_info,'".$result['errortext']."','no')</script>";
  exit;
 
}

?>
<form id='attach_form' action='NASAttach.php' method='post'>
  <input type='hidden' name='virtualmachineid' value='<?=$_POST['virtualmachineid']?>'/>
  <input type='hidden' name='networkid' value='<?=$result['response']['networkid']?>'/>
</form>
<?php 
  if($_POST['virtualmachineid'] != ""){
?>
<script>
Alert.render('NAS 서버 연결','서버와의 연결을 진행중 입니다.<br> 잠시만 기다려 주십시요....','');
document.getElementById('attach_form').submit();
</script>
<?php 
  } else { ?>
  <script>
    Confirm.render('NAS','NAS생성이 완료 되었습니다.<br>서버 연결은 따로 신청해 주십시요.',loca,'','no');
    </script>
 <?php 
  }
 ?>
</body>
</html>
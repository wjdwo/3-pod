<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/nonAsynCommandPageInclude.php');
?>
<!DOCTYPE>
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
</head><body>
<?php

 $cmdArr = array (
    "command" => "updateVolume",
    "id" => $_POST['id'],
    "totalsize" => $_POST['totalsize'],
    "apikey" => API_KEY
 );
$URL_NAS ="https://api.ucloudbiz.olleh.com/nas/v1/client/api?";
 set_time_limit(600);

 $result = callCommand($URL_NAS, $cmdArr, SECERET_KEY);
 //var_dump_enter($result);


if($result['status']=='error') {
  echo "<script>Confirm.render('NAS','".$result['errortext']."',err_info,'".$result['errortext']."','no')</script>";
  exit;
}

	echo "<script>Confirm.render('NAS','크기 변경이 신청 되었습니다.',loca,'','no')</script>";

?>


</body>

</html>
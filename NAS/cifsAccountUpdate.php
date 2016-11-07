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
		location.replace('cifsAccount.php');
	}
	var err_info = function(){
		history.back();
	}
</script>
</head>
<body>
<?php
$URL_NAS = "https://api.ucloudbiz.olleh.com/nas/v1/client/api?";
$cmdArr = array(
  "command" => "updateCifsAccount",
  "cifsId" => $_POST['cifsId'],
  "cifsPw" => $_POST['cifsPw'],
  "apikey" => API_KEY
);
$result = callCommand($URL_NAS, $cmdArr, SECERET_KEY);
set_time_limit(600);


if($result['status']=='error') {
  echo "<script>Confirm.render('CIFS Account','".$result['errortext']."',err_info,'','no')</script>";
  exit;
}

echo "<script>Confirm.render('CIFS Account','".$_POST['cifsId']." 계정의 비밀번호 변경 완료.',loca,'','no')</script>";


    
?>

</body>
</html>
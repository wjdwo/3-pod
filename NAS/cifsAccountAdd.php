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
  function sleep(num){  //[1/1000초]
    var now = new Date();
    var stop = now.getTime() + num;
    while(true){
      now = new Date();
      if(now.getTime() > stop)return;
    }
  }

	var loca = function(){
    sleep(500);
    window.opener.location.reload(true);
    window.close();
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
  "command" => "addCifsAccount",
  "cifsId" => $_POST['cifsId'],
  "cifsPw" => $_POST['cifsPw'],
  "apikey" => API_KEY
);
//var_dump_enter($cmdArr);
//exit;
$result = callCommand($URL_NAS, $cmdArr, SECERET_KEY);
set_time_limit(600);
/*
sleep(30);
*/

if($result['status']=='error') {
  echo "<script>Confirm.render('CIFS Account','".$result['errortext']."',err_info,'','no')</script>";
  exit;
  //echo "<script>location.replace('listNas.php');</script>";
}

echo "<script>Confirm.render('CIFS Account','cifs 계정 추가가 완료 되었습니다.',loca,'','no')</script>";


    
?>

</body>
</html>
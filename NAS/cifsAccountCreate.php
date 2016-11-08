
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<script src='cifs.js'>
</script>
<script type="text/javascript">
  var loca = function(){
   location.replace('cifsAccount.php');
  }
  var err_info = function(){
   location.replace('cifsAccount.php');
  }
</script>
<style>

</style>

</head>
<body>
<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/nonAsynCommandPageInclude.php');

$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
$URL_NAS = "https://api.ucloudbiz.olleh.com/nas/v1/client/api?";
$cmdArr = array(
  "command" => "listAccounts",
  "apikey" => API_KEY
);

$result = callCommand($URL, $cmdArr, SECERET_KEY);
$result_count;
if(isset($result['count']) == false){
  $result_count = 0;
}else {
  $result_count = $result['count'];
}

$account_id='';
$temp;
for( $i=0; $i<$result_count; $i++){
  if($result['count']==1){
    $temp = $result['account'];
  } else {
    $temp = $result['account'][$i];
  }
  if($temp['user']['apikey']==API_KEY){
    $account_id = $temp['user']['accountid'];
    break;
  }
}


$cmdArr = array(
  "command" => "addAccountForNas",
  "accountid" => $account_id,
  "cifsworkgroup" => "WORKGROUP",
  "apikey" => API_KEY
);


$result = callCommandJSON($URL_NAS, $cmdArr, SECERET_KEY);

if(isset($result['status'])) {
  if($result['status']=='error'){
    echo "<script>Confirm.render('CIFS Account','".$result['errortext']."',err_info,'','no')</script>";
    exit;
  }
}

echo "<script>Confirm.render('CIFS Account','cifs 그룹 추가가 완료 되었습니다.',loca,'','no')</script>";


?>


</body>


</html>

<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT']; 
include_once($server_root_path.'/includeFiles.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="/<?=CLOUD_PATH?>include/design.css">
<link rel="stylesheet" type="text/css" href="/<?=CLOUD_PATH?>include/menu_design.css">
<link rel="stylesheet" type="text/css" href="/<?=CLOUD_PATH?>alertBar/alert_bar_design.css">


</head>
<body>

<?php
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/menuPageInclude.php');

$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
$URL_NAS = "https://api.ucloudbiz.olleh.com/nas/v1/client/api?";
$cmdArr = array(
  "command" => "listAccounts",
  "apikey" => API_KEY
);

$result = callCommand($URL, $cmdArr, SECERET_KEY);
$result = $result['account'];

$cmdArr = array(
  "command" => "listVolumes",
  "apikey" => API_KEY
);
$result2 = callCommand($URL_NAS, $cmdArr, SECERET_KEY);
$result2_num = $result2['count'];
$online_num = 0;
$result2 = $result2['response'];
for($i=0; $i<$result2_num; $i++){
  if($result2_num == 1){
    $temp2 = $result2;
  } else {
    $temp2 = $result2[$i];
  }
  if($temp2['status']=='online')
    $online_num++;
}?>
<table class="fifty_left gray_line">
<tr class="background_gray"><td colspan="2"><b>Server</b></td></tr>
<tr>
<td style="width:50%">서버 갯수</td> <td style="width:50%"><?=$result['vmtotal']?></td>
</tr>

<tr>
<td>공인 IP 갯수</td> <td><?=$result['iptotal']?></td>
</tr>

<tr>
<td>Disk 갯수</td> <td><?=$result['volumetotal']?></td>
</tr>

</table>

<table class="fifty_left gray_line">
<tr class="background_gray"><td colspan="2"><b>NAS</b></td></tr>
<tr>
<td style="width:50%">NAS 갯수</td> <td style="width:50%"><?=$online_num?></td>
</tr>

</tr>
</table>

</body>


</html>

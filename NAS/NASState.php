<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/ajaxCalledPageInclude.php');

?>
<?php

$URL_NAS = "https://api.ucloudbiz.olleh.com/nas/v1/client/api?";
$listProductcmdArr = array(
    "command" => "listVolumes",
    "name" => $_POST['name'],
    "apikey" => API_KEY
);
$result = callCommand($URL_NAS, $listProductcmdArr, SECERET_KEY);

$result_num = $result['count'];
$temp = $result['response'];

?>
<tr class="background_gray">
  <td style="text-align: left" colspan='6'><b><?=$_POST['name']?></b> </td>
  <td style="text-align: right"><div id="serverStateClose" onclick="stateClose()">X </div></td>
</tr>
<tr>

  <td style="width:10%"><b>요금제</b></td>
  <td style="width:15%"><b>Mount Path</b></td>
  <td style="width:15%"><b>사용량</b></td>
  <td style="width:15%"><b>전체크기</b></td>
  <td style="width:15%"><b>file used</b></td>
  <td style="width:15%"><b>file total</b></td>
  <td style="width:15%"><b>autosize</b></td>
</tr>
<tr>
  <td><?=$temp['usageplantype']?></td>
  <td><?=$temp['ip']?>:/<?=$temp['path']?></td>
  <td id="usedsize"><size><?=$temp['usedsize']?><size></td>
  <td id="totalsize"><size><?=$temp['totalsize']?><size></td>
  <td><?=$temp['filesused']?></td>
  <td><?=$temp['filestotal']?></td>
  <?php
  if($temp['autoresize']=='false'){ ?>
    <td>지원 안함</td>
  <?php
  } else{  ?>
    <td id="autoresize"><size><?=$temp['incrementsize']?><size> / <size><?=$temp['maxsize']?><size></td>
  <?php
  }
  ?>
</tr>
<tr>
<td colspan='3'></td>
<td colspan='1'>
<form method="post" id="NAS_state_form">
<input type='hidden' name='id' value='<?= $temp['id']?>'/>
<input type='button' class='button' value='전체크기 변경' onclick='resizeNASVolume(this)'/>
<input type='button' class='button' id='submit_resize' style='display: none' value='변경 신청' onclick='resizeSubmit()'/>
</form>
</td>
<td colspan='3'></td>
</tr>
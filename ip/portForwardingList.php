<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT']; 
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/ajaxCalledPageInclude.php');
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8"/>

</head><body>
<?php
 $cmdArr = array (
    "command" => "listPortForwardingRules",
    "ipaddressid" => $_POST['ipaddressid'],
    "apikey" => API_KEY
 );

 $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
 $result = callCommand($URL, $cmdArr, SECERET_KEY);

if(count($result)!=0){
   $num = $result['count'];
   $result = $result['portforwardingrule'];
}else{
  $num = 0;
}
   ?>
 
 <tr class="background_gray"><td style="text-align: left" colspan="4"><b><?=$_POST['ipaddress']?></b></td>
 <td style="text-align: right"><div onclick="stateClose()">X</div></td></tr>
 <tr  class="background_gray">
    <td style="width: 20%">서버</td>
    <td style="width: 20%">프로토콜</td>
    <td style="width: 20%">외부번호</td>
    <td style="width: 20%">내부번호</td>
    <td style="width: 20%">-</td>
</tr>
 <?php
 for($i=0; $i<$num; $i++){
   if($num != '1' ) {
     $temp = $result[$i];
  }else {
     $temp = $result;
  }
  if($temp['state'] != "Active"){
    continue;
  }
  ?>

    <tr>
    
 
  <td><?= $temp['virtualmachinedisplayname'];?></td>
  <td><?=$temp['protocol']?></td>
  <td><?= $temp['publicport'];?> - <?= $temp['publicendport'];?></td>
  <td><?= $temp['privateport'];?> - <?= $temp['privateendport'];?></td>

  <td style="width:20%">
  <form  method="post"/>
   <input name="id" type="hidden" value="<?= $temp['id']?>"/>

  <input type="button" onclick="deletePortForwardingRules('<?=$i?>')" class="button2" value="삭제"/></td>
  </form>
 </tr>  
  <?php
 }
?>
</body>
</html>
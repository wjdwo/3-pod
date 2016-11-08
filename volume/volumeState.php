<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT']; 
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/ajaxCalledPageInclude.php');

?>
<?php

$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

$listProductcmdArr = array(
    "command" => "listVolumes",
    "apikey" => API_KEY
);
$result = callCommand($URL, $listProductcmdArr, SECERET_KEY);


$result_num = $result['count'];
$result = $result['volume'];

$temp;
for($i=0; $i<$result_num; $i++){
  if($result_num != '1' ) {
    $temp = $result[$i];
  }else {
    $temp = $result;
  }
  if($temp['id']==$_POST['id']){

    break;
  }
}

?>


<tr class="background_gray">
  <td style="text-align: left" colspan='3'>
    <b><?=$temp['name']?></b>
    
  
  </td>
  <td style="border-left-style: hidden; text-align: right"><div id="serverStateClose" onclick="stateClose('diskState')">X </div></td>
</tr>
<tr class="background_gray">
  <td  style="width: 75%" colspan='3'><b>서버 연결</b></td>
  <td style="width: 25%"> <b>Disk 삭제</b></td>
</tr>

<tr>
 <?php 
  if(isset($temp['vmname'])){ ?>

  <td style='width: 20%;'><b>연결 VM</b> </td>
  <td style='width: 35%'> 
  <?=$temp['vmdisplayname']?> : <?=$temp['vmstate']?> 
  </td>
  <td style='width: 20%'> 
    <form style="margin:0px;padding:0px;" id="serverForm" method="post">
      <input type='hidden' name='id' value="<?=$temp['id']?>"/>
<?php
      if(isset($temp['diskofferingname'])==false){
        echo "-";
      } else {
        echo "<input type='button' onclick='serverDettach()' class='button2' value='연결끊기'/>";
      }  
?>
      
    </form> 
  </td>
  
  <?php
  } else { 
  ?>
  
  <td style='width: 20%;'><b>VM 연결하기</b> </td>  
  <td style='width: 35%'>
  <form style="margin:0px;padding:0px;" id="serverForm" method="post"> 
  <input type='hidden' name='id' value="<?=$temp['id']?>"/>
<select name="virtualmachineid">
   <option value=''>-</option>

<?php 
  $listVMcmdArr = array(
    "command" => "listVirtualMachines",
    "zoneid" => $temp['zoneid'],
    "apikey" => API_KEY
);
$vmList = callCommand($URL, $listVMcmdArr, SECERET_KEY);
//var_dump_enter($vmList);

$vm_num = $vmList['count'];
$vm = $vmList['virtualmachine'];
$vm_temp;
for($i=0; $i<$vm_num; $i++){
  if($vm_num != '1' ) {
    $vm_temp = $vm[$i];
  }else {
    $vm_temp = $vm;
  }
  ?>
     <option value='<?=$vm_temp['id']?>'><?=$vm_temp['displayname']?></option>
<?php
}

  ?>


  </select> 
  </form>
  </td>
  <td style='width: 20%'>
    <input type='button' class='button2' value='연결하기' onclick="serverAttach()"/> 
  </td>
<?php
}?>

<td>
<form style="margin:0px;padding:0px;" id='serverDeleteForm'>
<input type='hidden' name='id' value='<?= $temp['id']?>'/>

<?php
if(isset($temp['diskofferingname'])==false){
  echo "<input type='button' class='button' value='삭제 불가능'/> ";
}
else if(strstr($temp['diskofferingname'],'additional')==true) {
  if(!isset($temp['vmstate']) ){
    echo "<input type='button' onclick='serverDelete()' class='button' value='삭제하기'/> ";
  } else {
    echo "<input type='button' class='button' value='VM 연결 해지를 해주세요.'/>";
  }
} else { echo "<input type='button' class='button' value='삭제 불가능'/> "; }
?>
</form>
</td>
</tr>
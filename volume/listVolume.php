
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
function makeByteToGB(byte){
  byte = Number(byte);
  document.write( byte/1024/1024/1024 +"GB" );
}
 var publicIp_length;
 function serverAttach(){
  var form = document.getElementById('serverForm');
  if(form.virtualmachineid.value=="") return false;
  form.action="volumeAttach.php";
  form.method = 'post';
  form.submit();
  Alert.render('Volume','서버와의 연결 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
 }
 function serverDettach(){
  var form = document.getElementById('serverForm');
  form.action="volumeDetach.php";
  form.method = 'post';
  form.submit();
  Alert.render('Volume','서버와의 연결 끊기 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
 }
  function serverDelete(){
    var form = document.getElementById('serverDeleteForm');
    form.action="volumeDelete.php";
    form.method = 'post';
    form.submit();
    Alert.render('Volume','삭제 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
  }
 
 function showDiskState(num){
    var id = document.forms[num].ipaddressid.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','volumeState.php');
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = 'id='+id;
    xhr.send(data);
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById('diskState').innerHTML = xhr.responseText; 
        }
      }
    document.getElementById('diskState').style.display = 'table';
  }

</script>
</head><body>
<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT']; 
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/menuPageInclude.php');
?>
<?php
 $cmdArr = array (
    "command" => "listVolumes",
    "apikey" => API_KEY
 );

 $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
 $result = callCommand($URL, $cmdArr, SECERET_KEY);

 $num = $result['count'];
 $result = $result['volume'];
?>
 <table class="noline hoverOn">




<tr class="background_gray">
  <td style="width:20%"><b>이름</b></td>
  <td style="width:15%"><b>지역</b></td>
  <td style="width:15%"><b>타입</b></td>
  <td style="width:15%"><b>용량</b></td>
  <td ><b>생성일</b></td>
</tr>

<?php 
for($i=0; $i<$num; $i++){ 
   if($num != '1' ) {
     $temp = $result[$i];
  }else {
     $temp = $result;
  }
  if($temp['destroyed']!='false') continue;
?>
  <tr>
  <td class='view' onclick="showDiskState('<?=$i?>')"><?= $temp['name'] ?></td>
  <td>
  <?=$temp['zonename']?>

  <form style="padding:0px; margin:0px" method='post'> 
  <input type='hidden' value='<?= $temp['zoneid']?>'/>
  <input name='ipaddressid' type='hidden' value='<?= $temp['id']?>'/>
  <input name='ipaddress' type='hidden' value='<?= $temp['ipaddress']?>'/>
  </form>

  </td>
  <td ><?= $temp['type']?></td>
  <td > <script>makeByteToGB('<?=$temp['size']?>');</script>  </td>
  <td><?=$temp['created']?></td>
  </tr>
  
 <?php  
 }
?>
</table>

</table>

<table style="display: none" class="gray_line" id="diskState">
<!--<tbody id="serverState">
<tr  class="background_gray">
  <td style="text-align: left" colspan='2'>(서버이름)</td>
  <td style="text-align: right"><div id="serverStateClose">X </div></td>
</tr>
<tr  ><td>상태</td><td>running?</td><td><form>실행 버튼들</form></td></tr>
</tbody> -->
</table>


</body>
</html>
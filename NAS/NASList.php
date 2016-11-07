<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT']; 
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/ajaxCalledPageInclude.php');

?>
<tr class="background_gray">
  <td style='width: 25%'><b>NAS</b></td>
  <td style='width: 25%'><b>type</b></td>
  <td style='width: 25%'><b>생성일</b></td>
  <td style='width: 25%'><b>-</b></td>
</tr>
<?php
$URL_NAS ="https://api.ucloudbiz.olleh.com/nas/v1/client/api?";
$listProductcmdArr = array(
    "command" => "listVolumes",
    "status" => "online",
    "apikey" => API_KEY
);

$result = callCommand($URL_NAS, $listProductcmdArr, SECERET_KEY);


$result_num = $result['count'];
if($result_num != 0)
	$result = $result['response'];

for($i=0; $i<$result_num; $i++){
  if($result_num != '1' ) {
    $temp = $result[$i];
  }else {
    $temp = $result;
  }

  if($temp['status']!='online') continue;
  if($temp['networkid']!=$_POST['networkid']) continue;
  echo "<tr><td class='view' onclick='showNASState(this)'>";
  echo $temp['name'];
  echo "</td> <td>";
  echo $temp['volumetype'];
  echo "</td> <td>";
  echo $temp['created'];
  echo "</td> <td><form method='post' action='deleteNAS.php'><input type='hidden' name='id' value='".$temp['id']."'/><input type='submit' class='button' value='삭제'/></form>";
  echo "</td> </tr>";

}

?>
</tbody>
</table>
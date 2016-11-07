<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT']; 
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/popUpPageInclude.php');
?>
<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="/<?=CLOUD_PATH?>include/design.css">
<meta charset="utf-8"/>
<script src='cifs.js'>

</script>
<style>

</style>

</head>
<body>
<?php

$URL_NAS = "https://api.ucloudbiz.olleh.com/nas/v1/client/api?";
$cmdArr = array(
  "command" => "listCifsAccounts",
  "apikey" => API_KEY
);

$result = callCommand($URL_NAS, $cmdArr, SECERET_KEY);



$cmdArr = array(
  "command" => "listAccountForNas",
  "apikey" => API_KEY
);

$result = callCommand($URL_NAS, $cmdArr, SECERET_KEY);
?>

<table id='cifsAccount' class="noHover gray_line">

<form id='cifsAccountForm' method='post' action='cifsAccountAdd.php'>
<tr>
  <td  class="background_gray" colspan='3'><b>CIFS계정 추가하기</b></td>
</tr>
<tr >
  <td>ID</td>
  <td>
<input class='transparent' type='text' name='cifsId' index=1/></td>
  <td style='width:20%' rowspan="2"><input type='button' index=3 class='button' onclick="formSubmit('cifsAccountForm')" value='제출'/></td>
</tr>
<tr>
  <td>PW</td>
  <td><input class='transparent'  type='password' name='cifsPw' index=2/>
</td>
</tr>
</form>
</table>
</body>


</html>

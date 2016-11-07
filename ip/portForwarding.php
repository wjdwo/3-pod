<?php
@session_start();
$server_root_path = $_SERVER['DOCUMENT_ROOT']; include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/asynCommandPageInclude.php');
?>

<!DOCTYPE>
<html>
<head>

<meta charset="utf-8"/>

<script>
    var loca = function(){
        location.replace('listPublicIP.php');
    }
    var err_info = function(){
        history.back();
    }
</script>
</head>

<body>
<?php


 $cmdArr = array (
    "command" => "createPortForwardingRule",
    "ipaddressid" => $_POST['ipaddressid'],
    "privateport" => $_POST['privateport'], 
    "protocol" =>  $_POST['protocol'],
    "publicport" => $_POST['publicport'],
    "virtualmachineid" => $_POST['virtualmachineid'],
    "openfirewall" => $_POST['openfirewall'],
    "apikey" => API_KEY
 );

 if($_POST['publicendport'] != "") {
 	$cmdArr['publicendport'] = $_POST['publicport'];
 }
 if($_POST['privateendport'] != "" ) {
 	$cmdArr['privateendport'] = $_POST['privateport'];
 }


 $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
 set_time_limit(600);

 $result = callCommand($URL, $cmdArr, SECERET_KEY);

?>




<?php

if(session_push('processID',$result['jobid'])){
    echo "<script>Confirm.render('Port Forwarding','신청이 완료 되었습니다',loca,'','no')</script>";

} else {
    echo "<script>Confirm.render('Port Forwarding','오류가 발생했습니다!',err_info,'','no')</script>";
}

?>
</body>

</html>

<!DOCTYPE>
<html>
<head>

<meta charset="utf-8"/>
</head><body>
<?php
include_once('sessionPush.php');
include_once('api_constants.php');
include_once('./callAPI.php');
include_once('var_dump_enter.php');
//  var_dump_enter($_POST);

 $cmdArr = array (
    "command" => "deleteFirewallRule",
    "id" => "error",
    "apikey" => API_KEY
 );
// var_dump_enter($cmdArr);

 $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
 set_time_limit(600);

 $result = callCommand($URL, $cmdArr, SECERET_KEY);
 var_dump_enter($result);

?>



<script src="asy.js"></script>
<?php
  session_push2('processID',$result['jobid']);
  echo $result['jobid'];
//  echo "<script>alert('방화벽 삭제 신청이 완료 되었습니다.')</script>";
//  echo "<script>location.replace('listFireWallRules.php');</script>";
?>
</body>

</html>
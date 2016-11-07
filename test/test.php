<?php
@session_start();

var_dump($_SESSION);
exit;
$server_root_path = $_SERVER['DOCUMENT_ROOT'];

include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/asynCommandPageInclude.php');
$cmdArr2 = array(
    "command" => "queryAsyncJobResult",
    "jobid" => $_POST['jobid'],
    "apikey"  => API_KEY
  );
  $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
$result = callCommand($URL, $cmdArr2, SECERET_KEY);

var_dump_enter($result);

        var_dump($_COOKIE);
?>
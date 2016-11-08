<?php @session_start();
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
include_once($server_root_path.'/includeFiles.php');
?>
<?php

include_once($server_root_path.'/'.CLOUD_PATH.'include/sessionPush.php');
include_once($server_root_path.'/'.CLOUD_PATH.'include/api_constants.php');
include_once($server_root_path.'/'.CLOUD_PATH.'include/callAPI.php'); 


$jobRank=$_POST['jobRank'];
  $cmdArr2 = array(
    "command" => "queryAsyncJobResult",
    "jobid" => $_POST['jobid'],
    "apikey"  => API_KEY
  );
  $URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";
  
  $result2 = callCommand($URL, $cmdArr2, SECERET_KEY);
  if(isset($result2['jobid'])){
    if($result2['jobid']=="ERROR"){
      echo "done : ERROR <br/>";
      unset($_SESSION['processID'][$jobRank]);
      exit;
    }
  }

  
  $jobStatus = $result2["jobstatus"];
  if ($jobStatus == 2) {
    echo $result2['cmd'];
    echo "done : work fail!<br/>";
    unset($_SESSION['processID'][$jobRank]);

  }
  else if ($jobStatus == 1 ) {    
    echo $result2['cmd'];
    if(isset($result2['jobresult']['virtualmachine']['password'])) {
      $id = $result2['jobresult']['virtualmachine']['id'];
      $password = $result2['jobresult']['virtualmachine']['password'];
      $_SESSION[$id] = $password;
      echo "password produce";
    }
/*
    if(isset($result2['jobresult']['virtualmachine']['state'])){
      if($result2['jobresult']['virtualmachine']['state'] == "Destroyed") {
        echo VM_DESTROY;
      }
    }
*/
    unset($_SESSION['processID'][$jobRank]);
    echo " done!";
  }
  else {
    echo "<img height='17px' src='/".CLOUD_PATH."include/load.gif'>";
  }
?>
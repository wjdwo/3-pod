<?php
@session_start();
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
include_once($server_root_path.'/includeFiles.php');

include_once($server_root_path.'/'.CLOUD_PATH.'include/api_constants.php');
	
$url = '/'.CLOUD_PATH;
if(!isset($_SESSION['ID'])) {
	$url .= 'login_notice.php';
	 echo "<script>location.replace('".$url."'); </script>";
	 exit;
}
if($_SESSION['ID'] != ID){
	$url .= 'sessionDestroy.php';
	echo "<script>location.replace('".$url."');</script>";
	 exit;
}


?>
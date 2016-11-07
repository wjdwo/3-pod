<?php
@session_start();
$server_root_path = $_SERVER['DOCUMENT_ROOT'];// ini_set('include_path',$server_root_path);
include_once($server_root_path.'/includeFiles.php');

include_once($server_root_path.'/'.CLOUD_PATH.'include/api_constants.php');
	
	$url = '/'.CLOUD_PATH;
	if(!isset($_SESSION['ID'])) {
		$url = $url.'login_notice.php';
	//	echo $url."<br>";
		 echo "<script>location.replace('".$url."'); </script>";
		 exit;
	}
	if($_SESSION['ID'] != ID){
		$url = $url.'sessionDestroy.php';
		echo "<script>location.replace('".$url."');</script>";
		 exit;
	}


?>
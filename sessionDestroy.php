<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT']; 
include_once($server_root_path.'/includeFiles.php');
?>

<?php
 include_once($server_root_path.'/'.CLOUD_PATH.'customAlert/customAlert.html');
	session_start();
	session_destroy();
	foreach($_COOKIE as $key=>$val){ 
	 setCookie($key,"",time()-1800); 
}
?>

<script>
	var loca = function(){
		location.replace('login_notice.php');
	}
	Confirm.render('LOG OUT','정상적으로 로그아웃 하셨습니다.',loca,'','no');

</script>
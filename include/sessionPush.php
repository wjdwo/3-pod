<?php
@session_start();
function session_push($key, $value){
	if($value == "ERROR"){
		return false;
	}
	if(!isset($_SESSION[$key])){
       $_SESSION[$key] = array();
    }
    array_push($_SESSION[$key], $value);
    return true;
}

//test case
function session_push2($key, $value){
	if($value == "ERROR"){
		echo"<script>alert('오류가 발생하였습니다.');</script>";
		return false;
	}
}
?>
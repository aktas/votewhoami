<?php 

session_start();
date_default_timezone_set('Europe/Istanbul');

function setSession($key,$val,$time=null){
	$key = trim($key);
	$val = trim($val);
	if(!is_null($time)){
		$time = trim($time);
		$array = array();
		array_push($array, $val,$time);
		$_SESSION[$key] = $array;
	}else{
		$_SESSION[$key] = $val;
	}
}

function getSession($key,$val){
	$key = trim($key);
	$val = trim($val);
	if(isset($_SESSION[$key])){
		if(is_array($_SESSION[$key])){
			$array = $_SESSION[$key];
			$time = time();
			if($array[1] <= $time){
				unset($_SESSION[$key]);
				return 0;
			}else{
				if($_SESSION[$key] == $val){
					return 1;
				}else{
					return 0;
				}
			}
		}else{
			if($_SESSION[$key] == $val){
				return 1;
			}else{
				return 0;
			}
		}
	}else{
		return 0;
	}
}

# time() + 20 şeklinde süre belirtilerek gönderilir. 
?>
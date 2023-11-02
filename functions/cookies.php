<?php 

function setCookieM($name,$val,$time){
	$time = time()+$time;
	$string = $val."-".$time;
	setcookie($name,$string,$time);
}

function cookieControl($name,$num){
	if(isset($_COOKIE[$name])){
		$arr = explode("-",$_COOKIE[$name]);
		if(is_numeric($arr[0])){
			$numC = $arr[0];
			if($numC >= $num){
				return 0;
			}else{
				return 2;
			}
		}else{
			return 0;
		}
	}else{
		return 1;
	}
}

?>
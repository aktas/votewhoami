<?php 

function security($val){
	$result = htmlspecialchars(stripslashes(trim($val)));
	return $result;
}

function encrypt($val){
	$result = md5(sha1(md5($val)));
	return $result;
}

?>
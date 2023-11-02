<?php 

function security($val){
	$result = htmlspecialchars(stripslashes(trim($val)));
	return $result;
}

?>
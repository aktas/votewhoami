<?php 
header('Content-Type: text/html; charset=utf-8');
$lan = substr(trim($_SERVER['HTTP_ACCEPT_LANGUAGE']),0,2);
if(isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])){
	if($lan == "tr"){
		header("Location:tr");
		exit;
	}else{
		header("Location:en");
		exit;
	}
}else{
	header("Location:en");
	exit;
}

?>
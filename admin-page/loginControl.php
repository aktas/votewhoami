<?php 

require_once "functions/sessions.php";
require_once "functions/security.php";
require_once "functions/routing.php";
require_once "classes/allClasses.php";

if(isset($_POST['adminLogin'])){ # login işlemi
	if(getSession("token",$_POST['token'])){
		unset($_SESSION['token']); 
		$login = new \votewhoami\login\login();
		$login->loginControl($_POST['username'],$_POST['password']);
		exit;
	}else{
		go("login","warning",1);
		exit;
	}
}

?>
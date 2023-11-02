<?php 

require_once "functions/sessions.php";
require_once "functions/security.php";
require_once "functions/cookies.php";
require_once "functions/routing.php";
require_once "functions/character.php";
require_once "classes/allClasses.php";
require_once "functions/visitors.php";

if(isset($_POST['searchGroups']) and isset($_POST['country'])){ # Grup araması
	if(getSession("token",$_POST['token'])){
		$groups = new \votewhoami\groups\groups();
		echo $groups->getGroups($_POST['country'],$_POST['link']);
		exit;
	}else{
		echo 1;
		exit;
	}
}

if(isset($_POST['searchGroup']) and isset($_POST['group'])){ # Grup üyeleri araması
	if(getSession("token",$_POST['token'])){
		$groups = new \votewhoami\groups\groups();
		echo $groups->getGroup($_POST['country'],$_POST['group'],$_POST['lan']);
		exit;
	}else{
		echo 1;
		exit;
	}
}

?>
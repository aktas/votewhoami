<?php

require_once "functions/sessions.php";
require_once "functions/security.php";
require_once "functions/cookies.php";
require_once "functions/routing.php";
require_once "functions/visitors.php";
require_once "functions/character.php";
require_once "classes/allClasses.php";

if(isset($_POST['getGroupMemberDetail']) && isset($_POST['token'])){ # Grup üye detayını aldık.
	if(getSession("token",$_POST['token'])){
		$groups = new \votewhoami\groups\groups();
		echo $groups->getGroupMemberDetail($_POST['id'],$_POST['language']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['getCharacterAdjectives']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$groups = new \votewhoami\groups\groups();
		echo $groups->getCharacterAdjectives($_POST['language']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['vote']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$vote = new \votewhoami\groups\groups();
		echo $vote->Vote($_POST['id'],$_POST['character']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['getActiveCharacters']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$vote = new \votewhoami\groups\groups();
		echo $vote->getActiveCharacters($_POST['id'],$_POST['language']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST["updateGroup"]) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$group = new \votewhoami\groups\groups();
		echo $group->updateGroup($_POST['id'],$_POST['groupName'],$_POST['special'],$_POST['editable'],$_POST['link']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['updateLinks']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$group = new \votewhoami\groups\groups();
		echo $group->updateLinks($_POST['id'],$_POST['link']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['addGroupMember']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$group = new \votewhoami\groups\groups();
		echo $group->addGroupMember($_POST['groupId'],$_POST['link'],$_POST['characters'],$_POST['memberName'],$_POST['language']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['addGroupMemberForVisitor']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$group = new \votewhoami\groups\groups();
		echo $group->addGroupMemberForVisitor($_POST['groupId'],$_POST['link'],$_POST['characters'],$_POST['memberName']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['deleteRow']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$group = new \votewhoami\groups\groups();
		echo $group->deleteGroupMember($_POST['groupId'],$_POST['id'],$_POST['link']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['createGroup']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$group = new \votewhoami\groups\groups();
		echo $group->createGroup($_POST['groupName'],$_POST['country'],$_POST['special'],$_POST['editable'],$_POST['language']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['deleteGroup']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$group = new \votewhoami\groups\groups();
		echo $group->deleteGroup($_POST['groupId'],$_POST['link']);
		exit;
	}else{
		echo 0;
		exit;
	}
}elseif(isset($_POST['sendMessage']) && isset($_POST['token'])){
	if(getSession("token",$_POST['token'])){
		$send = new \votewhoami\message\message();
		$send = (string) $send->addMessage($_POST['name'],$_POST['email'],$_POST['message']);
		$url = trim($_POST['url']);
		go($url."-".$send);
	}else{
		header("Location:index.php");
		exit;
	}
}elseif(isset($_POST['okCookie'])){
	$ip = getIp();
	$cookie = new \votewhoami\cookie\cookie();
	$cookie = $cookie->cookie($ip);
	return $cookie;
}else{
	header("Location:index.php");
	exit;
}

?>
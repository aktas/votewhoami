<?php 
ini_set("display_errors",1);
header('Content-Type: text/html; charset=utf-8');
require_once "functions/sessions.php";
require_once "functions/security.php";
require_once "functions/routing.php";
require_once "functions/visitors.php";
require_once "functions/character.php";

if(!isset($_SESSION['VWAIadmin'])){
	header("Location:login");
	exit;
}

require_once "classes/allClasses.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_GET['statu']) and $_GET['statu'] == "exit"){ # çıkış
	session_destroy();
	go("login","success",1);
	exit;
}elseif(isset($_POST['updateSettings']) and isset($_POST['city'])){ # updateIMG,varsa?
	if(getSession("token",$_POST['token'])){
		(isset($_FILES['file'])) ? $file = $_FILES['file'] : $file = NULL;
		$admin = new \votewhoami\admin\admin();
		$admin->updateSettings($_POST['name'],$_POST['username'],$_POST['city'],$_POST['statu'],$file);
		exit;
	}else{
		go("settings","warning",1);
		exit;
	}
}elseif(isset($_POST['newPasswordAgain']) and isset($_POST['newPassword']) and isset($_POST['updatePassword'])){ # password update
	if(getSession("token",$_POST['token'])){
		$admin = new \votewhoami\admin\admin();
		$admin->updatePassword($_POST['password'],$_POST['newPassword'],$_POST['newPasswordAgain']);
		exit;
	}else{
		go("settings","warning",1);
		exit;
	}
}elseif(isset($_POST['updateSocial']) and isset($_POST['instagram_tr'])){ # social update
	if(getSession("token",$_POST['token'])){
		$admin = new \votewhoami\admin\admin();
		$admin->updateSocial($_POST['instagram_tr'],$_POST['instagram_en']);
		exit;
	}else{
		go("settings","warning",1);
		exit;
	}
}elseif(isset($_POST['updateMetaTags']) and isset($_POST['title_tr'])){ # metatags update
	if(getSession("token",$_POST['token'])){
		$admin = new \votewhoami\admin\admin();
		$admin->updateMetaTags($_POST['title_tr'],$_POST['title_en'],$_POST['google'],$_POST['description_tr'],$_POST['description_en'],$_POST['keywords_tr'],$_POST['keywords_en']);
		exit;
	}else{
		go("settings","warning",1);
		exit;
	}
}elseif(isset($_POST['updateSmtp']) and isset($_POST['smtpEmail'])){ # smtp update
	if(getSession("token",$_POST['token'])){
		$admin = new \votewhoami\admin\admin();
		$admin->updateSMTP($_POST['smtpEmail'],$_POST['smtpPassword'],$_POST['smtpPasswordAgain']);
		exit;
	}else{
		go("settings","warning",1);
		exit;
	}
}elseif(isset($_GET['messagesDelete']) and isset($_GET['id'])){ # message delete
	if(getSession("token",$_GET['token'])){
		$id = security($_GET['id']);
		$messages = new \votewhoami\admin\messages();
		if($messages->Delete("DELETE FROM messages WHERE id = ?",array($id))){
			go("contact","success",2);
			exit;
		}else{
			go("contact","warning",1);
			exit;
		}
	}else{
		go("contact","warning",1);
		exit;
	}
}elseif(isset($_POST['sendMail']) and isset($_POST['email'])){ # Send Mail
	if(getSession("token",$_POST['token'])){
		$admin = new \votewhoami\admin\admin();
		$admin = $admin->getRow("SELECT * FROM admin WHERE id = 1");
		$messages = new \votewhoami\admin\messages();
		$array = $messages->securityMessage($_POST['email'],$_POST['subject'],$_POST['message']);

		$smtpPassword = ltrim($admin->smtpPassword,"Kt2bN9");
		$smtpPassword = rtrim($smtpPassword,"Vz27=");
		$smtpPassword = trim(base64_decode($smtpPassword));
		$mail = new PHPMailer(true);
		$mail->SMTPDebug = 2;     
		$mail->CharSet = 'UTF-8';                
		$mail->isSMTP();                        
		$mail->Host       = 'smtp.gmail.com';   
		$mail->SMTPAuth   = true;                            
		$mail->Username   = $admin->smtpEmail;              
		$mail->Password   = $smtpPassword;                             
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
		$mail->Port       = 587;
		$mail->isHTML(true);  
			  	
		if(strtoupper($_POST['language']) == "TR"){
			$mail->setFrom($array[0], 'VOTE WHO AM I');
			$mail->addReplyTo("votewhoami@gmail.com", 'Cevapla');
			$title = "BEN KİMİM OYLA";
			$l = "Bu mesaj <a href=\"https://votewhoami.com\" style=\"color:#aaa\">votewhoami.com</a> sitesi gönderimli mesajdır.";
		}else{
			$mail->setFrom($array[0], 'VOTE WHO AM I');
			$mail->addReplyTo("votewhoami@gmail.com", 'Reply To');
			$title = "VOTE WHO AM I";
			$l = "This message is the posted message from the <a href=\"https://votewhoami.com\" style=\"color:#aaa\">votewhoami.com</a> site";
		}
		
		$mail->Subject = $array[1];
		$mail->Body    = '<!DOCTYPE html>
<html>
<head>
	<title>'.$title.'</title>
	<meta charset="utf-8">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&family=Raleway:wght@300&display=swap" rel="stylesheet"> 
</head>
<body>
	<div style="width:100%; border:1px solid #ccc; font-family: Quicksand; margin: 0 auto; position: relative; max-width: 750px; border-radius: 10px; box-sizing: border-box; padding: 20px;">
		<h3 style="text-align: center; ">'.$title.'</h3> 
		<p>'.$array[2].'</p>
		<span style="display:block; text-align: center; color:#aaa; text-align: center; margin-bottom: -15px; ">'.$l.'</span>
	</div>
</body>
</html>';
			  	
		$mail->addAddress($array[0]);  
			    
		if($mail->send()){
			go("contact","success",2);
			exit;
		}else{
			go("contact","warning",1);
			exit;
		}
	}else{
		echo 0;
	}
}elseif(isset($_POST['addGroup']) and isset($_POST['country'])){ # Group Add
	if(getSession("token",$_POST['token'])){
		$special = isset($_POST['special']) ? "on" : "off";
		$editable = isset($_POST['editable']) ? "on" : "off";
		$groups = new \votewhoami\groups\groups();
		$groups->addGroups($_POST['country'],$_POST['groupLanguage'],$_POST['groupName'],$special,$editable);
		exit;
	}else{
		go("groups","warning",1);
		exit;
	}
}elseif(isset($_POST['updateGroup']) and isset($_POST['country'])){ # Update group
	if(getSession("token",$_POST['token'])){
		$special = isset($_POST['special']) ? "on" : "off";
		$editable = isset($_POST['editable']) ? "on" : "off";
		$groups = new \votewhoami\groups\groups();
		$groups->updateGroup($_POST['id'],$_POST['country'],$_POST['language'],$_POST['groupName'],$special,$editable);
		exit;
	}else{
		go("groups","warning",1);
		exit;
	}
}elseif(isset($_GET['updateLinks']) and isset($_GET['id'])){ # Group update links
	if(getSession("token",$_GET['token'])){
		$groups = new \votewhoami\groups\groups();
		$groups->updateLinks($_GET['id'],$_GET['country']);
		exit;
	}else{
		go("groups","warning",1);
		exit;
	}
}elseif(isset($_GET['deleteGroup']) and isset($_GET['id'])){ # Delete group
	if(getSession("token",$_GET['token'])){
		$groups = new \votewhoami\groups\groups();
		$groups->deleteGroup($_GET['id']);
		exit;
	}else{
		go("groups","warning",1);
		exit;
	}
}elseif(isset($_GET['groupMemberDelete']) and isset($_GET['id'])){ # Delete group member
	if(getSession("token",$_GET['token'])){
		$groups = new \votewhoami\groups\groups();
		$groups->groupMemberDelete($_GET['id']);
		exit;
	}else{
		go("groups","warning",1);
		exit;
	}
}elseif(isset($_POST['addGroupMember']) and isset($_POST['name'])){ # Update group
	if(getSession("token",$_POST['token'])){
		$groups = new \votewhoami\groups\groups();
		$groups->addGroupMember($_POST['groupId'],$_POST['name'],$_POST['characters']);
		exit;
	}else{
		go("groups","warning",1);
		exit;
	}
}else{
	go("login");
	exit;
}



?>
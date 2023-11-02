<?php 

namespace votewhoami\admin;

class messages extends \votewhoami\db\database{
	public function securityMessage($email,$subject,$message){
		if((mb_strlen(trim($email),'UTF-8') > 150) or (mb_strlen(trim($subject),'UTF-8') > 125) or (mb_strlen(trim($message),'UTF-8') > 10000) or (mb_strlen(trim($email),'UTF-8') < 4) or (mb_strlen(trim($subject),'UTF-8') < 3) or (mb_strlen(trim($message),'UTF-8') < 2)){
			go("contact","warning",1);
			exit;
		}else{
			if(filter_var($email,FILTER_VALIDATE_EMAIL)){
				$email = security($email);
				$subject = security($subject);
				$message = security($message);
				$array = array();
				array_push($array,$email,$subject,$message);
				return $array;
			}else{
				go("contact","warning",1);
				exit;
			}
		}
	}
}

?>
<?php 

namespace votewhoami\message;

class message extends \votewhoami\db\database{ 

	public function addMessage($name,$email,$message){
		$ip = getIp();
		$name = security($name);
		$email = security($email);
		$message = security($message);
		if(($name == "") || ($email == "") || ($message == "") || ($name == null) || ($email == null) || ($message == null) || (mb_strlen($message) > 2000) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
			return 0;
		}else{
			$c = cookieControl("votewhoamiMessage",3);
			if(($c == 1) || ($c == 2)){
				$select = parent::getRows("SELECT * FROM messages WHERE messagesIp = ?",array($ip));
				if(count($select) >= 10){
					return 2;
				}else{
					$insert = parent::Insert("INSERT INTO messages SET messagesIp = ?, messagesName = ?, messagesEmail = ?, messagesContent = ?",array($ip,$name,$email,$message));
					if($insert){
						if($c == 1){
							setCookieM("votewhoamiMessage",1,300); // 5 dakika
						}else{
							$arr = explode("-",$_COOKIE["votewhoamiMessage"]);
							$arr[0] = $arr[0] + 1;
							$string = implode("-",$arr);
							setcookie("votewhoamiMessage",$string,$arr[1]);
						}
						return 1;
					}else{
						return 0;
					}
				}
			}else{
				return 2;
			}
		}
	}

}


?>
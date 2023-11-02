<?php 

namespace votewhoami\login;

class login extends \votewhoami\db\database{
	public function loginControl($username,$password){
		if((isset($username)) and (isset($password))){
			if((mb_strlen(security($username),"UTF-8") < 8) || (mb_strlen(security($username),"UTF-8") > 34) || (mb_strlen(security($password),"UTF-8") < 8) || (mb_strlen(security($username),"UTF-8") > 34)){
				go("login","warning",1);
				exit;
			}else{
				$username = security($username);
				$password = encrypt($password);
				$select = parent::getRow("SELECT * from admin WHERE username = ? and password = ?",array($username,$password));
				if($select){
					$_SESSION['VWAIadmin'] = $select->id;
					session_regenerate_id(true);
					go("index");
					exit;
				}else{
					go("login","warning",2);
					exit;
				}
			}
		}else{
			go("login","warning",1);
			exit;
		}
	}
}


?>
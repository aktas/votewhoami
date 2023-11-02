<?php 

namespace votewhoami\cookie;

class cookie extends \votewhoami\db\database{

	public function getCookie($ip){
		$ip = security($ip);
		$select = parent::getRow("SELECT * FROM visitors WHERE visitorsIp = ? AND visitorsCookiesControl = 1",array($ip));
		if($select){
			return 0;
		}else{
			return 1;
		}
	}

	public function cookie($ip){
		$ip = security($ip);
		$select = parent::getRow("SELECT * FROM visitors WHERE visitorsIp = ?",array($ip));
		if($select){
			$update = parent::Update("UPDATE visitors SET visitorsCookiesControl = 1 WHERE visitorsIp = ?",array($ip));
			if($update){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}

}

?>
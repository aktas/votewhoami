<?php 
ini_set("display_errors",1);
function GetIP(){
  if(getenv("HTTP_CLIENT_IP")) {
    $ip = getenv("HTTP_CLIENT_IP");
  } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
    $ip = getenv("HTTP_X_FORWARDED_FOR");
    if (strstr($ip, ',')) {
      $tmp = explode (',', $ip);
      $ip = trim($tmp[0]);
    }
  } else {
    $ip = getenv("REMOTE_ADDR");
  }
  return $ip;
}

function getLanguage(){
	if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
		$lan = substr(trim($_SERVER['HTTP_ACCEPT_LANGUAGE']),0,2);
	}else{
		$lan = "en";
	}
	return strtolower($lan);
}

function getPlatform(){
	if(isset($_SERVER['HTTP_USER_AGENT'])){
		if (preg_match('/linux/i', $_SERVER['HTTP_USER_AGENT'])) {
         	$platform = 'linux';
     	}
     	elseif (preg_match('/macintosh|mac os x/i', $_SERVER['HTTP_USER_AGENT'])) {
         	$platform = 'mac';
     	}
     	elseif (preg_match('/windows|win32/i', $_SERVER['HTTP_USER_AGENT'])) {
         	$platform = 'windows';
     	}else{
     		$platform = 'other';
     	}
	}else{
		$platform = "other";
	}
	return strtolower($platform);
}

function getAgent(){
	if(isset($_SERVER['HTTP_USER_AGENT'])){
		if(preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT']) && !preg_match('/Opera/i',$_SERVER['HTTP_USER_AGENT'])){ 
	         $bname = 'Internet Explorer'; 
	         $agent = "MSIE"; 
	     } 
	     elseif(preg_match('/Firefox/i',$_SERVER['HTTP_USER_AGENT'])){ 
	         $bname = 'Mozilla Firefox'; 
	         $agent = "Firefox"; 
	     } 
	     elseif(preg_match('/Chrome/i',$_SERVER['HTTP_USER_AGENT'])){ 
	         $bname = 'Google Chrome'; 
	         $agent = "Chrome"; 
	     } 
	     elseif(preg_match('/Safari/i',$_SERVER['HTTP_USER_AGENT'])){ 
	         $bname = 'Apple Safari'; 
	         $agent = "Safari"; 
	     } 
	     elseif(preg_match('/Opera/i',$_SERVER['HTTP_USER_AGENT'])){ 
	         $bname = 'Opera'; 
	         $agent = "Opera"; 
	     } 
	     elseif(preg_match('/Netscape/i',$_SERVER['HTTP_USER_AGENT'])){ 
	         $bname = 'Netscape'; 
	         $agent = "Netscape"; 
	     }else{
	     	$agent = 'other';
	     }
	}else{
		$agent = 'other';
	}
    return strtolower($agent);
}


function getVisitor(){
	if(!isset($_COOKIE['VWAIvisitor'])){
		setcookie("VWAIvisitor",1,time() + 600,"/",null,true,true);
		$ip = security(GetIP());
		$db = new \votewhoami\db\database();
		$select = $db->getRow("SELECT * from visitors WHERE visitorsIp = ?",array($ip));
		if($select){
			$num = $select->visitorsClick;
			$num++;
			$update = $db->Update("UPDATE visitors SET visitorsClick = ? WHERE visitorsIp = ?",array($num,$ip));
		}else{
			$lan = security(getLanguage());
			$agent = security(getAgent());
			$platform = security(getPlatform());
			$insert = $db->Insert("INSERT INTO visitors SET visitorsIp = ? , visitorsPlatform = ?, visitorsAgent = ?, visitorsLanguage = ?",array($ip,$platform,$agent,$lan));
		}
	}
}

?>
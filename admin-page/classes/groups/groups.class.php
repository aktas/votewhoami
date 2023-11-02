<?php 

namespace votewhoami\groups;

class groups extends \votewhoami\db\database{
	public function addGroups($country,$language,$groupName,$special,$editable){
		if((mb_strlen(trim($country), 'UTF-8') < 1) or (mb_strlen(trim($groupName), 'UTF-8') < 2) or (mb_strlen(trim($country), 'UTF-8') > 100) or (mb_strlen(trim($groupName), 'UTF-8') > 250)){
			go("groups","warning",1);
			exit;
		}else{
			$country = security($country);
			$groupName = security($groupName);
			$groupSpecial = security($special);
			$groupEditable = security($editable);
			$language = security($language);
			$ip = GetIp();

			$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
			$seed2 = str_split('$K*.!_');
    		shuffle($seed);
    		shuffle($seed2);
    		$random = '';
    		$random2 = '';
    		foreach (array_rand($seed, 5) as $k) $random .= $seed[$k];
    		foreach (array_rand($seed2, 5) as $k) $random2 .= $seed2[$k];
			$viewLink = md5(uniqid(mt_rand(), true)).uniqid().$random.uniqid();
			foreach (array_rand($seed, 5) as $k) $random .= $seed[$k];
    		foreach (array_rand($seed2, 5) as $k) $random2 .= $seed2[$k];
			$editLink = md5(uniqid(mt_rand(), true)).uniqid().$random.uniqid().uniqid().$random2.uniqid();
			
			$viewLink = mb_strtolower($language)."-".$viewLink;
			$editLink = mb_strtolower($language)."-".$editLink;
			
			

			$select = parent::getRow("SELECT * FROM groups WHERE groupVLink = ? or groupELink = ?",array($viewLink,$editLink));
			if($select){
				go("groups","warning",1);
				exit;
			}else{
				$insert = parent::Insert("INSERT INTO groups SET groupVIp = ?, groupCountry = ?, groupLanguage = ?, groupName = ?, groupVLink = ?, groupELink = ?, groupSpecial = ?, groupEditable = ?",array($ip,$country,$language,$groupName,$viewLink,$editLink,$groupSpecial,$groupEditable));
				if($insert){
					go("groups","success",1);
					exit;
				}else{
					go("groups","warning",1);
					exit;
				}
			}
			
		}
	}

	public function updateGroup($id,$country,$language,$groupName,$special,$editable){
		if((mb_strlen(trim($country), 'UTF-8') < 1) or (mb_strlen(trim($groupName), 'UTF-8') < 2) or (mb_strlen(trim($country), 'UTF-8') > 100) or (mb_strlen(trim($groupName), 'UTF-8') > 250) or (!is_numeric($id))){
			go("groups","warning",1);
			exit;
		}else{
			$country = security($country);
			$groupName = security($groupName);
			$groupSpecial = security($special);
			$groupEditable = security($editable);
			$language = security($language);
			$id = security($id);
			$update = parent::Update("UPDATE groups SET groupCountry = ?, groupLanguage = ?, groupName = ?, groupSpecial = ?, groupEditable = ? WHERE id = ?",array($country,$language,$groupName,$groupSpecial,$groupEditable,$id));
			if($update){
				go("group.php?id=".$id."&islem=ok");
				exit;
			}else{
				go("groups","warning",1);
				exit;
			}
			
		}
	}

	public function updateLinks($id,$country){
		if(!is_numeric($id)){
			go("groups","warning",1);
			exit;
		}else{
			$id = security($id);
			$select = parent::getRow("SELECT * FROM groups WHERE id = ?",array($id));
			$language = $select->groupLanguage;
			$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
			$seed2 = str_split('$K*.!_');
    		shuffle($seed);
    		shuffle($seed2);
    		$random = '';
    		$random2 = '';
    		foreach (array_rand($seed, 5) as $k) $random .= $seed[$k];
    		foreach (array_rand($seed2, 5) as $k) $random2 .= $seed2[$k];
			$viewLink = md5(uniqid(mt_rand(), true)).uniqid().$random.uniqid();
			foreach (array_rand($seed, 5) as $k) $random .= $seed[$k];
    		foreach (array_rand($seed2, 5) as $k) $random2 .= $seed2[$k];
			$editLink = md5(uniqid(mt_rand(), true)).uniqid().$random.uniqid().uniqid().$random2.uniqid();
			
			$viewLink = mb_strtolower($language)."-".$viewLink;
			$editLink = mb_strtolower($language)."-".$editLink;
			
			$update = parent::Update("UPDATE groups SET groupVLink = ?, groupELink = ? WHERE id = ?",array($viewLink,$editLink,$id));
			if($update){
				go("group.php?id=".$id."&islem=ok");
				exit;
			}else{
				go("groups","warning",1);
				exit;
			}
		}
	}

	public function deleteGroup($id){
		if(!is_numeric($id)){
			go("groups","warning",1);
			exit;
		}else{
			$id = security($id);

			$delete = parent::Delete("DELETE FROM groups WHERE id = ?",array($id));
			if($delete){
				go("groups","success",1);
				exit;
			}else{
				go("groups","warning",1);
				exit;
			}
		}
	}

	public function groupMemberDelete($id){
		if(!is_numeric($id)){
			go("groups","warning",1);
			exit;
		}else{
			$id = security($id);

			$delete = parent::Delete("DELETE FROM groupMembers WHERE id = ?",array($id));
			if($delete){
				go("groups","success",1);
				exit;
			}else{
				go("groups","warning",1);
				exit;
			}
		}
	}

	public function addGroupMember($id,$name,$characters){
		if((!is_array($characters)) or (!is_numeric($id))){
			go("groups","warning",1);
			exit;
		}else{
			$select = parent::getRow("SELECT * FROM groups WHERE id = ?",array($id));
			$language = $select->groupLanguage;
			$char = "";
			if($language == "English"){
				$characters = convertEN($characters);
			}
			foreach ($characters as $key) {
				$char .= ",".mb_strtolower(trim($key));
			}
			$char = security(trim(rtrim(ltrim($char,","),",")));
			$name = security($name);
			$ip = GetIp();
			$insert = parent::Insert("INSERT INTO groupMembers SET groupId = ?, ip = ?, name = ?, characters = ?",array($id,$ip,$name,$char));
			if($insert){
				go("group.php?id=".$id."&islem=ok");
				exit;
			}else{
				go("groups","warning",1);
				exit;
			}
		}

	}
}


?>
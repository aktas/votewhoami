<?php 

namespace votewhoami\groups;

class groups extends \votewhoami\db\database{
	public function getGroups($country,$link){
		$link = security($link);
		$group = parent::getRow("SELECT * FROM groups WHERE groupVLink = ?",array($link));
		if(!$group){
			$group = parent::getRow("SELECT * FROM groups WHERE groupELink = ?",array($link));
		}
		if(!$group){
			$country = security($country);
			$groups = parent::getRows("SELECT * FROM groups WHERE groupCountry = ? AND groupSpecial = 'off'",array($country));
			$x = count($groups);
			if($x){
				shuffle($groups);
				$string = "<option val=''>Select Group</option>---";
				
				foreach ($groups as $key) {
					$id = $key->id;
					$string .= "<option val='$id'>".trim($key->groupName)."</option>---";
				}
				return $string;
			}else{
				return 2;
			}
		}else{
			$country = security($country);
			$groups = parent::getRows("SELECT * FROM groups WHERE groupCountry = ? AND groupSpecial = 'off'",array($country));
			$x = count($groups);
			if($x){
				shuffle($groups);
				$string = "<option val=''>Select Group</option>---";
				foreach ($groups as $key) {
					$id = $key->id;
					$string .= "<option val='$id'>".trim($key->groupName)."</option>---";
				}
				if($group->groupSpecial == "on"){
					$id = $group->id;
					$string .= "<option val='$id'>".trim($group->groupName)."</option>---";
				}
				
				return $string;
			}else{
				return 2;
			}
		}
	}

	public function getGroup($country,$group,$language){ # Sayfanın dilini aldık ve grubun diliyle kontrol ettireceğiz.
		$country = security($country);
		$group = security($group);
		$groups = parent::getRow("SELECT * FROM groups WHERE id = ?",array($group));
		$groupMembers = parent::getRows("SELECT * FROM groupMembers WHERE groupId = ?",array($group));
		if($groups){
			$string = "";
			$lan = $groups->groupLanguage;
			foreach ($groupMembers as $key) {
				$id = $key->id;
				$name = $key->name;
				if(trim($key->characters) == "" || trim($key->characters) == NULL){
					if($groups->groupLanguage == "Turkish"){
						$characters = "tanimsiz";
					}else{
						$characters = "undefined";
					}
					$array = explode(",",trim($characters));
				}else{
					$array = explode(",",trim($key->characters));
				}
				$characters = explode(",",rtrim(convert($array,$lan,$language),","));
				$characters = array_count_values($characters);
				arsort($characters);
				$characters = array_keys($characters);
				$characters = implode(",",$characters);

				$string .= "$name---$characters---$id-----";
			}
			return $string;
		}else{
			return 2;
		}
	}

	public function getGroupMemberDetail($id,$language){
		$id = security($id);
		$member = parent::getRow("SELECT * FROM groupMembers WHERE id = ?",array($id));
		$group = parent::getRow("SELECT * FROM groups WHERE id = ?",array($member->groupId));
		if(trim($member->characters) == ""){
			if($group->groupLanguage == "Turkish"){
				$c = "tanimsiz";
			}else{
				$c = "undefined";
			}
		}else{
			$c = $member->characters;
		}
		$array = getGroupMemberDetail($c,$group->groupLanguage,security($language));
		echo $array;
	}

	public function getCharacterAdjectives($lan){
		$array = getCharacter($lan);
		echo json_encode($array);
	}

	public function Vote($id,$character){
		$id = security($id);
		$character = mb_strtolower(security($character));
		$ip = getIp();
		if(($ip != NULL)){
			$member = parent::getRow("SELECT * FROM groupMembers WHERE id = ?",array($id));
			if($member){
				$groupId = $member->groupId;
				$vote = parent::getRow("SELECT * FROM memberVote WHERE groupId = ? AND groupMemberId = ? AND ip = ?",array($groupId,$id,$ip));
				if($vote){
					$c1 = getCharacterLanguage($character);
					$arr = explode(",",trim($member->characters));
					$c2 = getCharacterLanguage($arr[0]);
					$character = ($c1 != $c2) ? convert2($character) : mb_strtolower(trim($character));
					$arr2 = explode(",",trim($vote->characters));
					if(in_array($character,$arr2)){
						foreach ($arr2 as $key => $value) {
							if($value == $character){
								unset($arr2[$key]);
								break;
							}
						}
						$string = implode(",",$arr2);
						$vote = parent::Update("UPDATE memberVote SET characters = ? WHERE groupId = ? AND groupMemberId = ? AND ip = ?",array($string,$groupId,$id,$ip));

						$arr = explode(",",trim($member->characters));
						foreach ($arr as $key => $value) {
							if($value == $character){
								unset($arr[$key]);
								break;
							}
						}
						$string = implode(",",$arr);
						$update = parent::Update("UPDATE groupMembers SET characters = ? WHERE id = ?",array($string,$id));

						$vote = parent::getRow("SELECT * FROM memberVote WHERE groupId = ? AND groupMemberId = ? AND ip = ?",array($groupId,$id,$ip));
						if(trim($vote->characters) == NULL){
							$delete = parent::Delete("DELETE FROM memberVote WHERE groupId = ? AND groupMemberId = ? AND ip = ?",array($groupId,$id,$ip));
							if($delete){
								echo 2;
							}else{
								echo 0;
							}
						}else{
							if($update){
								echo 2;
							}else{
								echo 0;
							}
						}
					}else{
						$num = count($arr2);
						if($num >= 3){
							echo 1;
						}else{
							array_push($arr2, $character);
							$string = implode(",",$arr2);
							$vote = parent::Update("UPDATE memberVote SET characters = ? WHERE groupId = ? AND groupMemberId = ? AND ip = ?",array($string,$groupId,$id,$ip));

							$arr = explode(",",trim($member->characters));
							array_push($arr, $character);
							$string = implode(",",$arr);
							$update = parent::Update("UPDATE groupMembers SET characters = ? WHERE id = ?",array($string,$id));

							if($update){
								echo 2;
							}else{
								echo 0;
							}
						}
					}
				}else{
					$c1 = getCharacterLanguage($character);
					$arr = explode(",",trim($member->characters));
					$c2 = getCharacterLanguage($arr[0]);
					$character = ($c1 != $c2) ? convert2($character) : mb_strtolower(trim($character));

					$arr = explode(",",trim($member->characters));
					array_push($arr, $character);
					$string = implode(",",$arr);
					$update = parent::Update("UPDATE groupMembers SET characters = ? WHERE id = ?",array($string,$id));

					$vote = parent::Insert("INSERT INTO memberVote SET groupId = ? , groupMemberId = ? , ip = ? , characters = ?",array($groupId,$id,$ip,$character));
					if($vote){
						echo 2;
					}else{
						echo 0;
					}
					
				}
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}

	}

	public function getActiveCharacters($id,$language){
		$id = security($id);
		$ip = getIp();
		if($ip != NULL){
			$memberVote = parent::getRow("SELECT * FROM memberVote WHERE groupMemberId = ? AND ip = ?",array($id,$ip));
			if($memberVote){
				$groupId = $memberVote->groupId;
				$group = parent::getRow("SELECT * FROM groups WHERE id = ?",array($groupId));
				$arr = explode(",",trim($memberVote->characters));
				$arr = convert2($arr,$group->groupLanguage,$language);
				echo json_encode($arr);
			}else{
				echo 1;
			}
		}else{
			echo 0;
		}
	}

	public function updateGroup($id,$groupName,$special,$editable,$link){
		$groupName = security($groupName);
		print(type($special));
		$special = (security($special) == "true") ? "on" : "off";
		$editable = (security($editable) == "true") ? "on" : "off";
		$id = intval(security($id));
		$link = security($link);
		if((mb_strlen($groupName) < 2) || (mb_strlen($groupName > 150))){
			echo 1;
		}else{
			$c = parent::getRow("SELECT * FROM groups WHERE groupName = ?",array($groupName));
			if(count($c) > 0){
				echo "nameProblem";
			}else{
				$select = parent::getRow("SELECT * FROM groups WHERE id = ?",array($id));
				if(($groupName == $select->groupName) && ($special == $select->groupSpecial) && ($editable == $select->groupEditable)){
					echo 2;
				}else{
					$update = parent::Update("UPDATE groups SET groupName = ?, groupSpecial = ?, groupEditable = ? WHERE id = ? AND groupELink = ?",array($groupName,$special,$editable,$id,$link));
					if($update){
						echo 3;
					}else{
						echo 0;
					}
				}
			}
		}
	}

	public function updateLinks($id,$link){
		$id = security($id);
		$link = security($link);

		$select = parent::getRow("SELECT * FROM groups WHERE id = ? AND groupELink = ?",array($id,$link));
		if($select){
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

			$update = parent::Update("UPDATE groups SET groupVLink = ?, groupELink = ? WHERE id = ? AND groupELink = ?",array($viewLink,$editLink,$id,$link));
			if($update){
				echo $editLink;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}

	public function addGroupMember($id,$link,$characters,$memberName){
		if(mb_strlen(trim($memberName)) > 35){
			return "nameLimitProblem";
		}else{
			$id = security($id);
			$link = security($link);
			$ip = getIp();
			$characters = mb_strtolower(trim(trim(security($characters),",")));
			if($ip != null){
				if($characters != null){
					$memberName = security($memberName);
					$nameControl = parent::getRow("SELECT * FROM groupMembers WHERE groupId = ? AND name = ?",array($id,$memberName));
					if($nameControl){
						return "nameProblem";
					}else{
						$select = parent::getRow("SELECT * FROM groups WHERE id = ? AND groupELink = ?",array($id,$link));
						if($select){
							$cookieC = cookieControl("votewhoamiGroupMember",100);
							if(($cookieC == 1) || ($cookieC == 2)){
								$arr = explode(",",$characters);
								$c = getCharacterLanguage(mb_strtolower(trim($arr[0])));
								$c2 = $select->groupLanguage;
								if($c != $c2){
									convert2($characters,$c,$c2);
								}else{
									$new = "";
									$characters = explode(",",$characters);
									foreach ($characters as $key => $value) {
										$new = $new.trim($value).",";
									}
									$characters = trim($new,",");
								}
								$insert = parent::Insert("INSERT INTO groupMembers SET groupId = ? , ip = ? , name = ? , characters = ?",array($id,$ip,$memberName,$characters));
								$newId = $insert;
								if($insert){
									$insert =  parent::Insert("INSERT INTO memberVote SET groupId = ? , groupMemberId = ? , ip = ? , characters = ?",array($id,$newId,$ip,$characters));
									if($insert){
										if($cookieC == 1){
											setCookieM("votewhoamiGroupMember",1,30); // 30 saniye
										}else{
											$arr = explode("-",$_COOKIE["votewhoamiGroupMember"]);
											$arr[0] = $arr[0] + 1;
											$string = implode("-",$arr);
											setcookie("votewhoamiGroupMember",$string,$arr[1]);
										}
										return $newId;
									}else{
										return 0;
									}
								}else{
									return 0;
								}
							}else{
								return "cookieProblem";
							}
						}else{
							return 0;
						}
					}
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
		
	}

	public function addGroupMemberForVisitor($id,$link,$characters,$memberName){
		if(mb_strlen(trim($memberName)) > 35){
			return "nameLimitProblem";
		}else{
			$id = security($id);
			$link = security($link);
			$ip = getIp();
			$characters = mb_strtolower(trim(trim(security($characters),",")));
			if($ip != null){
				if($characters != null){
					$memberName = security($memberName);
					$nameControl = parent::getRow("SELECT * FROM groupMembers WHERE groupId = ? AND name = ?",array($id,$memberName));
					if($nameControl){
						return "nameProblem";
					}else{
						$select = parent::getRow("SELECT * FROM groups WHERE id = ? AND groupVLink = ?",array($id,$link));
						if($select){
							$cookieC = cookieControl("votewhoamiGroupMember",100);
							if(($cookieC == 1) || ($cookieC == 2)){
								$arr = explode(",",$characters);
								$c = getCharacterLanguage(mb_strtolower(trim($arr[0])));
								$c2 = $select->groupLanguage;
								if($c != $c2){
									convert2($characters,$c,$c2);
								}else{
									$new = "";
									$characters = explode(",",$characters);
									foreach ($characters as $key => $value) {
										$new = $new.trim($value).",";
									}
									$characters = trim($new,",");
								}
								$insert = parent::Insert("INSERT INTO groupMembers SET groupId = ? , ip = ? , name = ? , characters = ?",array($id,$ip,$memberName,$characters));
								$newId = $insert;
								if($insert){
									$insert =  parent::Insert("INSERT INTO memberVote SET groupId = ? , groupMemberId = ? , ip = ? , characters = ?",array($id,$newId,$ip,$characters));
									if($insert){
										if($cookieC == 1){
											setCookieM("votewhoamiGroupMember",1,30); // 30 saniye
										}else{
											$arr = explode("-",$_COOKIE["votewhoamiGroupMember"]);
											$arr[0] = $arr[0] + 1;
											$string = implode("-",$arr);
											setcookie("votewhoamiGroupMember",$string,$arr[1]);
										}
										return $newId;
									}else{
										return 0;
									}
								}else{
									return 0;
								}
							}else{
								return "cookieProblem";
							}
						}else{
							return 0;
						}
					}
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
	}

	public function deleteGroupMember($groupId,$id,$link){
		$groupId = security($groupId);
		$id = security($id);
		$link = security($link);
		$select = parent::getRow("SELECT * FROM groups WHERE id = ? AND groupELink = ?",array($groupId,$link));
		if($select){
			$delete = parent::Delete("DELETE FROM groupMembers WHERE id = ?",array($id));
			if($delete){
				$delete = parent::Delete("DELETE FROM memberVote WHERE groupMemberId = ?",array($id));
				echo 2;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}

	public function createGroup($groupName,$country,$special,$editable,$language){
		$groupName = security($groupName);
		$country = security($country);
		$groupSpecial = (security($special) == "true") ? "on" : "off";
		$groupEditable = (security($editable) == "true") ? "on" : "off";
		$language = security($language);
		if(($groupName == "") || ($groupName == null) || ($country == "") || ($country == null) || ($groupSpecial == "") || ($groupSpecial == null) || ($groupEditable == "") || ($groupEditable == null) || ($language == "") || ($language == null)){
			return 0;
		}else{
			$c = cookieControl("votewhoamiCreateGroup",3);
			if(($c == 1) || ($c == 2)){
				$ip = getIp();
				$groups = parent::getRows("SELECT * FROM groups WHERE groupVIp = ?",array($ip));
				if(count($groups) >= 100){
					return 2;
				}else{
					if((mb_strlen($groupName) < 2) || (mb_strlen($groupName) > 105)){
						return 1;
					}else{
						$nameControl = parent::getRow("SELECT * FROM groups WHERE groupName = ?",array($groupName));
						if($nameControl){
							return "nameProblem";
						}else{
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
								return 0;
							}else{
								$insert = parent::Insert("INSERT INTO groups SET groupVIp = ?, groupCountry = ?, groupLanguage = ?, groupName = ?, groupVLink = ?, groupELink = ?, groupSpecial = ?, groupEditable = ?",array($ip,$country,$language,$groupName,$viewLink,$editLink,$groupSpecial,$groupEditable));
								if($insert){
									$id = intval($insert);
									$select = parent::getRow("SELECT * FROM groups WHERE id = ?",array($id));
									if($select){
										if($c == 1){
											setCookieM("votewhoamiCreateGroup",1,600); // 10 dakika
										}else{
											$arr = explode("-",$_COOKIE["votewhoamiCreateGroup"]);
											$arr[0] = $arr[0] + 1;
											$string = implode("-",$arr);
											setcookie("votewhoamiCreateGroup",$string,$arr[1]);
										}
										return $select->groupELink;
									}else{
										return 0;
									}
								}else{
									return 0;
								}
							}
						}
					}
					
				}
			}else{
				return 2;
			}
		}
	}

	public function deleteGroup($groupId,$link){
		$id = security($groupId);
		$link = security($link);
		$select = parent::getRow("SELECT * FROM groups WHERE id = ? AND groupELink = ?",array($id,$link));
		if($select){
			$delete = parent::Delete("DELETE FROM groups WHERE id = ?",array($id));
			if($delete){
				$delete = parent::Delete("DELETE FROM groupMembers WHERE groupId = ?",array($id));
				$delete = parent::Delete("DELETE FROM memberVote WHERE groupId = ?",array($id));
				echo 2;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}

}

?>
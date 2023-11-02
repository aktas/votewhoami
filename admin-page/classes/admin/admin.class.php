<?php 

namespace votewhoami\admin;

class admin extends \votewhoami\db\database{
	public function updateSettings($name,$username,$city,$statu,$file){
		if(is_null($file)){
			if((mb_strlen(trim($name),'UTF-8') > 34) or (mb_strlen(trim($username),'UTF-8') > 34) or (mb_strlen(trim($city),'UTF-8') > 50) or (mb_strlen(trim($statu),'UTF-8') > 25) or (mb_strlen(trim($name),'UTF-8') < 4) or (mb_strlen(trim($username),'UTF-8') < 6) or (mb_strlen(trim($city),'UTF-8') < 2) or (mb_strlen(trim($statu),'UTF-8') < 2)){
				go("settings","warning",1);
				exit;
			}else{
				$name = security($name);
				$username = security($username);
				$city = security($city);
				$statu = security($statu);
				$update = parent::Update("UPDATE admin SET name = ?, username = ?, city = ?, statu = ? WHERE id = 1",array($name,$username,$city,$statu));
				if($update){
					go("settings","success",2);
					exit;
				}else{
					go("settings","warning",1);
					exit;
				}
			}
		}else{
			if((mb_strlen(trim($name),'UTF-8') > 34) or (mb_strlen(trim($username),'UTF-8') > 34) or (mb_strlen(trim($city),'UTF-8') > 50) or (mb_strlen(trim($statu),'UTF-8') > 25) or (mb_strlen(trim($name),'UTF-8') < 4) or (mb_strlen(trim($username),'UTF-8') < 6) or (mb_strlen(trim($city),'UTF-8') < 2) or (mb_strlen(trim($statu),'UTF-8') < 2)){
				go("settings","warning",1);
				exit;
			}else{
				$fileError = $file['error'];
				$fileName = $file['name'];
				$fileExtension = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
				$fileNewName = uniqid()."_".uniqid().".".$fileExtension;
				$fileType = $file['type'];
				$fileSize = $file['size'];
				$fileTmpName = $file['tmp_name'];
				$myPath = "img/".$fileNewName;
				if($fileError > 0){
					go("settings","warning",3);
					exit;
				}else{
					if(file_exists($fileNewName)){
						go("settings","warning",4);
						exit;
					}else{
						if($fileSize > 3000000){
							go("settings","warning",5);
							exit;
						}else{
							$allowed = array("png","jpg","jpeg","pneg");
							if(!in_array($fileExtension,$allowed)){
								go("settings","warning",6);
								exit;
							}else{
								$look = getimagesize($fileTmpName);
								if($look === false){
									go("settings","warning",7);
									exit;
								}else{
									if(move_uploaded_file($fileTmpName, $myPath)){
										$name = security($name);
										$username = security($username);
										$city = security($city);
										$statu = security($statu);
										$update = parent::Update("UPDATE admin SET img = ?, name = ?, username = ?, city = ?, statu = ? WHERE id = 1",array($fileNewName,$name,$username,$city,$statu));
										if($update){
											go("settings","success",2);
											exit;
										}else{
											go("settings","warning",1);
											exit;
										}
									}else{
										go("settings","warning",1);
										exit;
									}
								}
							}
						}
					}
				}
			}
		}
	}

	public function updatePassword($password,$newPassword,$newPasswordAgain){
		if((mb_strlen(trim($password),'UTF-8') > 38) or (mb_strlen(trim($password),'UTF-8') < 6) or (mb_strlen(trim($newPassword),'UTF-8') > 38) or (mb_strlen(trim($newPassword),'UTF-8') < 6) or (mb_strlen(trim($newPasswordAgain),'UTF-8') > 38) or (mb_strlen(trim($newPasswordAgain),'UTF-8') < 6)){
			go("settings","warning",1);
			exit;
		}else{
			$password = encrypt($password);
			$select = parent::getRow("SELECT * FROM admin WHERE password = ? and id = 1",array($password));
			if($select){
				$newPassword = encrypt($_POST['newPassword']);
				$newPasswordAgain = encrypt($_POST['newPasswordAgain']);
				if($newPassword == $newPasswordAgain){
					$update = parent::Update("UPDATE admin SET password = ? WHERE id = 1",array($newPassword));
					if($update){
						go("settings","success",2);
						exit;
					}else{
						go("settings","warning",1);
						exit;
					}
				}else{
					go("settings","warning",9);
					exit;
				}
			}else{
				go("settings","warning",8);
				exit;
			}
		}
	}

	public function updateSocial($tr,$en){
		if((mb_strlen(trim($tr),'UTF-8') > 350) or (mb_strlen(trim($tr),'UTF-8') < 4) or (mb_strlen(trim($en),'UTF-8') > 350) or (mb_strlen(trim($en),'UTF-8') < 4)){
			go("settings","warning",1);
			exit;
		}else{
			$tr = security($tr);
			$en = security($en);
			$update = parent::Update("UPDATE admin SET instagramTr = ?, instagramEn = ? WHERE id = 1",array($tr,$en));
			if($update){
				go("settings","success",2);
				exit;
			}else{
				go("settings","warning",1);
				exit;
			}
		}
	}

	public function updateMetaTags($titleTr,$titleEn,$google,$descriptionTr,$descriptionEn,$keywordsTr,$keywordsEn){
		if((mb_strlen(trim($titleTr),'UTF-8') > 50) or (mb_strlen(trim($titleTr),'UTF-8') < 4) or (mb_strlen(trim($titleEn),'UTF-8') > 50) or (mb_strlen(trim($titleEn),'UTF-8') < 4) or (mb_strlen(trim($google),'UTF-8') > 500) or (mb_strlen(trim($google),'UTF-8') < 4) or (mb_strlen(trim($descriptionTr),'UTF-8') > 300) or (mb_strlen(trim($descriptionTr),'UTF-8') < 25) or (mb_strlen(trim($descriptionEn),'UTF-8') > 500) or (mb_strlen(trim($descriptionEn),'UTF-8') < 4) or (mb_strlen(trim($keywordsTr),'UTF-8') > 500) or (mb_strlen(trim($keywordsTr),'UTF-8') < 4) or (mb_strlen(trim($keywordsEn),'UTF-8') < 4)){
			go("settings","warning",1);
			exit;
		}else{
			$titleTr = security($titleTr);
			$titleEn = security($titleEn);
			$google = security($google);
			$descriptionTr = security($descriptionTr);
			$descriptionEn = security($descriptionEn);
			$keywordsTr = security($keywordsTr);
			$keywordsEn = security($keywordsEn);
			$update = parent::Update("UPDATE admin SET titleTr = ?, titleEn = ?, descriptionTr = ?, descriptionEn = ?, keywordsTr = ?, keywordsEn = ?, googleSiteVerification = ? WHERE id = 1",array($titleTr,$titleEn,$descriptionTr,$descriptionEn,$keywordsTr,$keywordsEn,$google));
			if($update){
				go("settings","success",2);
				exit;
			}else{
				go("settings","warning",1);
				exit;
			}
		}
	}

	public function updateSMTP($smtpEmail,$smtpPassword,$smtpPasswordAgain){
		if((mb_strlen(trim($smtpEmail),'UTF-8') > 100) or (mb_strlen(trim($smtpEmail),'UTF-8') < 4) or (mb_strlen(trim($smtpPassword),'UTF-8') > 100) or (mb_strlen(trim($smtpPassword),'UTF-8') < 4)){
			go("settings","warning",1);
			exit;
		}else{
			$smtpEmail = security($smtpEmail);
			$smtpPassword = security($smtpPassword);
			$smtpPasswordAgain = security($smtpPasswordAgain);
			if($smtpPassword == $smtpPasswordAgain){
				$smtpPassword = "Kt2bN9".base64_encode($smtpPassword)."Vz27=";
				$update = parent::Update("UPDATE admin SET smtpEmail = ?, smtpPassword = ? WHERE id = 1",array($smtpEmail,$smtpPassword));
				if($update){
					go("settings","success",2);
					exit;
				}else{
					go("settings","warning",1);
					exit;
				}
			}else{
				go("settings","warning",9);
				exit;
			}
		}
	}
}


?>
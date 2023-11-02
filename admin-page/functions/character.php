<?php 

function convert2($val,$lan="Turkish",$lan2="English"){
	if($lan == $lan2){ # Sayfanın dili ile grubun dili aynıysa dönüştürme yapmadan gerekli kontrolleri yaparak geri döndürüyoruz.
		if(is_array($val)){
			$valC = "";
			foreach ($val as $value) {
				$valC .= trim($value).",";
			}
			$val = $valC;
		}else{
			$val = $value;
		}
		return mb_strtolower(trim(trim($val),","));
	}else{
		$arrayTR = array("guvenilir","iyi-kalpli","durust","saygili","sefkatli","merhametli","sadakatli","yardimsever","hosgorulu","neseli","fedakar","vefali","adaletli","sevimli","guleryuzlu","duyarli","dogal","arkadascanlisi","ahlakli","anlayisli","gorgulu","azimli","eglenceli","esnek","acikfikirli","etkileyici","akilli","comert","iyimser","dikkatli","zeki","sabirli","kulturlu","alcakGonullu","becerikli","nazik","enerjik","mantikli","bilgili","uyumlu","duzenli","dakik","caliskan","basarili","sempatik","zarif","insafli","esprili","coskulu","yapici","yetenekli","prensipli","dusunceli","yenilikci","medeni","cevik","sosyal","guclu","girisken","agirbasli","gercekci","istikrarli","cekici","aktif","duygusal","delidolu","ozgur","ozgun","romantik","asil","sanatkar","maceraci","farkli","gozupek","tutumlu","disadonuk","atilgan","temkinli","siradisi","siradan","konuskan","hirsli","ciddi","entelektüel","titiz","muzip","hayalperest","rahat","sorgulayici","hazircevap","cocuksu","mukemmelliyetci","geleneksel","itaatkar","utangac","sessiz","muhafazakar","havali","inatci","cekingen","suskun","kuskucu","supheci","tanimsiz");
	
		$arrayEN = array("trustworthy","kind-hearted","honest","respectful","compassionate","merciful","loyal","helpful","tolerant","joyous","self-sacrificing","faithful","just","pretty","good-humored","sensitive","natural","friendly","moral","understanding","well-mannered","determined","amusing","flexible","open-minded","attracting","smart","generous","optimistic","careful","intelligent","patient","cultured","humble","skillful","polite","energetic","logical","knowledgeable","agreeable","organized","punctual","hardworking","successful","sympathetic","elegant","merciful","witty","exuberant","constructive","talented","principled","considerate","innovative","civilized","nimble","sociable","strong","easygoer","earnest","realistic","stable","attractive","active","emotional","foolhardy","free","original","romantic","noble","artistic","adventurous","different","daredevil","frugal","extraverted","dashing","deliberative","extraordinary","ordinary","talkative","ambitious","serious","intellectual","meticulous","prankish","daydreamer","relaxed","skeptical","quick-witted","childish","perfectionist","traditional","obedient","shy","quiet","conservative","glitzy","stubborn","timid","silent","sceptical","suspicious","undefined");
		$x = 0;

		if(is_array($val)){
			$valC = "";
			foreach ($val as $value) {
				if(in_array(trim($value),$arrayTR)){
					foreach ($arrayTR as $key => $value2) {
						if(trim($value) == $value2){
							$x = $key;
							break;
						}
					}
					$valC .= trim($arrayEN[$x]).", ";
				}else{
					foreach ($arrayEN as $key => $value2) {
						if(trim($value) == $value2){
							$x = $key;
							break;
						}
					}
					$valC .= trim($arrayTR[$x]).", ";
				}
			}
			$val = $valC;
		}else{
			if(in_array($val,$arrayTR)){
				foreach ($arrayTR as $key => $value) {
					if(trim($val) == $value){
						$x = $key;
						break;
					}
				}
				$val = trim($arrayEN[$x]);
			}else{
				foreach ($arrayEN as $key => $value) {
					if(trim($val) == $value){
						$x = $key;
						break;
					}
				}
				$val = trim($arrayTR[$x]);
			}
		}
	}
	

	return mb_strtolower(trim(trim($val),","));
}

function getCharacter($lan="EN"){
	if($lan == "TR"){
		$array = array("guvenilir" => "Güvenilir","iyiKalpli" => "İyi kalpli","durust" => "Dürüst","saygili" => "Saygılı","sefkatli" => "Şefkatli","merhametli" => "Merhametli","sadakatli" =>"Sadakatli","yardimsever"=>"Yardımsever","hosgorulu"=>"Hoşgörülü","neseli"=>"Neşeli","fedakar"=>"Fedakâr","vefali"=>"Vefalı","adaletli"=>"Adaletli","sevimli"=>"Sevimli","guleryuzlu"=>"Güleryüzlü","duyarli"=>"Duyarlı","dogal"=>"Doğal","arkadasCanlisi"=>"Arkadaş canlısı","ahlakli"=>"Ahlaklı","anlayisli"=>"Anlayışlı","gorgulu"=>"Görgülü","azimli"=>"Azimli","eglenceli"=>"Eğlenceli","esnek"=>"Esnek","acikFikirli"=>"Açık fikirli","etkileyici"=>"Etkileyici","akilli"=>"Akıllı","comert"=>"Cömert","iyimser"=>"İyimser","dikkatli"=>"Dikkatli","zeki"=>"Zeki","sabirli"=>"Sabırlı","kulturlu"=>"Kültürlü","alcakGonullu"=>"Alçak gönüllü","becerikli"=>"Becerikli","nazik"=>"Nazik","enerjik"=>"Enerjik","mantikli"=>"Mantıklı","bilgili"=>"Bilgili","uyumlu"=>"Uyumlu","duzenli"=>"Düzenli","dakik"=>"Dakik","caliskan"=>"Çalışkan","basarili"=>"Başarılı","sempatik"=>"Sempatik","zarif"=>"Zarif","insafli"=>"İnsaflı","esprili"=>"Esprili","coskulu"=>"Coşkulu","yapici"=>"Yapıcı","yetenekli"=>"Yetenekli","prensipli"=>"Prensipli","dusunceli"=>"Düşünceli","yenilikci"=>"Yenilikçi","medeni"=>"Medeni","cevik"=>"Çevik","sosyal"=>"Sosyal","guclu"=>"Güçlü","girisken"=>"Girişken","agirbasli"=>"Ağırbaşlı","gercekci"=>"Gerçekçi","istikrarli"=>"İstikrarlı","cekici"=>"Çekici","aktif"=>"Aktif","duygusal"=>"Duygusal","deliDolu"=>"Deli dolu","ozgur"=>"Özgür","ozgun"=>"Özgün","romantik"=>"Romantik","asil"=>"Asil","sanatkar"=>"Sanatkar","maceraci"=>"Maceracı","farklı"=>"Farklı","gozupek"=>"Gözüpek","tutumlu"=>"Tutumlu","disaDonuk"=>"Dışa dönük","atilgan"=>"Atılgan","temkinli"=>"Temkinli","siradisi"=>"Sıradışı","siradan"=>"Sıradan","konuskan"=>"Konuşkan","hirsli"=>"Hırslı","ciddi"=>"Ciddi","entelektüel"=>"Entelektüel","titiz"=>"Titiz","muzip"=>"Muzip","hayalperest"=>"Hayalperest","rahat"=>"Rahat","sorgulayici"=>"Sorgulayıcı","hazircevap"=>"Hazırcevap","cocuksu"=>"Çocuksu","mukemmelliyetci"=>"Mükemmelliyetçi","geleneksel"=>"Geleneksel","itaatkar"=>"İtaatâr","utangac"=>"Utangaç","sessiz"=>"Sessiz","muhafazakar"=>"Muhafazakar","havali"=>"Havalı","inatci"=>"İnatçı","cekingen"=>"Çekingen","suskun"=>"Suskun","kuskucu"=>"Kuşkucu","supheci"=>"Şüpheci","tanimsiz"=>"Tanımsız");
	}else{
		$array = array("trustworthy" => "Trustworthy","kind-hearted" => "Kind-hearted","honest" => "Honest","respectful" => "Respectful","compassionate" => "Compassionate","merciful" => "Merciful","loyal" =>"Loyal","helpful"=>"Helpful","tolerant"=>"Tolerant","joyous"=>"Joyous","self-sacrificing"=>"Self-sacrificing","faithful"=>"Faithful","just"=>"Just","pretty"=>"Pretty","good-humored"=>"Good-humored","sensitive"=>"Sensitive","natural"=>"Natural","friendly"=>"Friendly","moral"=>"Moral","understanding"=>"Understanding","well-mannered"=>"Well-mannered","determined"=>"Determined","amusing"=>"Amusing","flexible"=>"Flexible","open-minded"=>"Open-minded","attracting"=>"Attracting","smart"=>"Smart","generous"=>"Generous","optimistic"=>"Optimistic","careful"=>"Careful","intelligent"=>"Intelligent","patient"=>"Patient","cultured"=>"Cultured","humble"=>"Humble","skillful"=>"Skillful","polite"=>"Polite","energetic"=>"Energetic","logical"=>"Logical","knowledgeable"=>"Knowledgeable","agreeable"=>"Agreeable","organized"=>"Organized","punctual"=>"Punctual","hardworking"=>"Hardworking","successful"=>"Successful","sympathetic"=>"Sympathetic","elegant"=>"Elegant","merciful"=>"Merciful","witty"=>"Witty","exuberant"=>"Exuberant","constructive"=>"Constructive","talented"=>"Talented","principled"=>"Principled","considerate"=>"Considerate","innovative"=>"Innovative","civilized"=>"Civilized","nimble"=>"Nimble","sociable"=>"Sociable","strong"=>"Strong","easygoer"=>"Easygoer","earnest"=>"Earnest","realistic"=>"Realistic","stable"=>"Stable","attractive"=>"Attractive","active"=>"Active","emotional"=>"Emotional","foolhardy"=>"Foolhardy","free"=>"Free","original"=>"Original","romantic"=>"Romantic","noble"=>"Noble","artistic"=>"Artistic","adventurous"=>"Adventurous","different"=>"Different","daredevil"=>"Daredevil","frugal"=>"Frugal","extraverted"=>"Extraverted","dashing"=>"Dashing","deliberative"=>"Deliberative","extraordinary"=>"Extraordinary","ordinary"=>"Ordinary","talkative"=>"Talkative","ambitious"=>"Ambitious","serious"=>"Serious","intellectual"=>"Intellectual","meticulous"=>"Meticulous","prankish"=>"Prankish","daydreamer"=>"Daydreamer","relaxed"=>"Relaxed","skeptical"=>"Skeptical","quick-witted"=>"Quick-witted","childish"=>"Childish","perfectionist"=>"Perfectionist","traditional"=>"Traditional","obedient"=>"Obedient","shy"=>"Shy","quiet"=>"Quiet","conservative"=>"Conservative","glitzy"=>"Glitzy","stubborn"=>"Stubborn","timid"=>"Timid","silent"=>"Silent","sceptical"=>"Sceptical","suspicious"=>"Suspicious","undefined"=>"Undefined");
	}
	
	return $array;
}

function convertEN($arr){
	$arrayTR = array("guvenilir","iyiKalpli","durust","saygili","sefkatli","merhametli","sadakatli","yardimsever","hosgorulu","neseli","fedakar","vefali","adaletli","sevimli","guleryuzlu","duyarli","dogal","arkadasCanlisi","ahlakli","anlayisli","gorgulu","azimli","eglenceli","esnek","acikFikirli","etkileyici","akilli","comert","iyimser","dikkatli","zeki","sabirli","kulturlu","alcakGonullu","becerikli","nazik","enerjik","mantikli","bilgili","uyumlu","duzenli","dakik","caliskan","basarili","sempatik","zarif","insafli","esprili","coskulu","yapici","yetenekli","prensipli","dusunceli","yenilikci","medeni","cevik","sosyal","guclu","girisken","agirbasli","gercekci","istikrarli","cekici","aktif","duygusal","deliDolu","ozgur","ozgun","romantik","asil","sanatkar","maceraci","farklı","gozupek","tutumlu","disaDonuk","atilgan","temkinli","siradisi","siradan","konuskan","hirsli","ciddi","entelektüel","titiz","muzip","hayalperest","rahat","sorgulayici","hazircevap","cocuksu","mukemmelliyetci","geleneksel","itaatkar","utangac","sessiz","muhafazakar","havali","inatci","cekingen","suskun","kuskucu","supheci","tanimsiz");
	
	$arrayEN = array("trustworthy","kind-hearted","honest","respectful","compassionate","merciful","loyal","helpful","tolerant","joyous","self-sacrificing","faithful","just","pretty","good-humored","sensitive","natural","friendly","moral","understanding","well-mannered","determined","amusing","flexible","open-minded","attracting","smart","generous","optimistic","careful","intelligent","patient","cultured","humble","skillful","polite","energetic","logical","knowledgeable","agreeable","organized","punctual","hardworking","successful","sympathetic","elegant","merciful","witty","exuberant","constructive","talented","principled","considerate","innovative","civilized","nimble","sociable","strong","easygoer","earnest","realistic","stable","attractive","active","emotional","foolhardy","free","original","romantic","noble","artistic","adventurous","different","daredevil","frugal","extraverted","dashing","deliberative","extraordinary","ordinary","talkative","ambitious","serious","intellectual","meticulous","prankish","daydreamer","relaxed","skeptical","quick-witted","childish","perfectionist","traditional","obedient","shy","quiet","conservative","glitzy","stubborn","timid","silent","sceptical","suspicious","undefined");
	$x = 0;

	if(in_array($arr[0],$arrayTR)){
		$arr2 = array();
		foreach ($arr as $value) {
			foreach ($arrayTR as $key => $value2) {
				if($value == $value2){
					array_push($arr2, $arrayEN[$key]);
					break;
				}
			}
		}
		return $arr2;
	}else{
		$arr2 = array();
		foreach ($arr as $val) {
			array_push($arr2,$val);
		}
		return $arr2;
	}

}

?>
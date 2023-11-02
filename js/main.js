var letters = { "İ": "i", "ı": "i", "Ş": "s", "Ğ": "g", "Ü": "u", "Ö": "o", "Ç": "c", "ş": "s", "ğ":"g", "ü":"u", "ö":"o", "ç":"c"," ":"-" };
function convert(val){
	val = val.trim();
	val = val.replace(/(([İıŞĞÜÇÖşğüçö ]))/g, function(letter){ return letters[letter]; });
	return val.toLowerCase().trim();
}
let capitalLetters = ["A","B","C","Ç","D","E","F","G","Ğ","H","İ","I","J","K","L","M","N","O","Ö","P","R","S","Ş","T","U","Ü","V","Y","Z"];
let string = "inan benİ yapmadım!";
function toFirstUpper(val){
	val = JSON.stringify(val).replace('"','').replace('[','').replace(']','').replace('[','').replace('"]','').replace('["','').replace(']]','').replace('"','').replace('["','').replace('"','').trim();
	if((val.indexOf(",")) != -1){
		let arr = val.split(",");
		let rVal = "";
		arr.forEach(function(v){ 
			v = v.trim();
			let c = v.substr(0,1);
			let r = capitalLetters.indexOf(c);
			if(r == -1){
				if(c == "i"){
					v = v.replace("i","İ");
				}else if(c == "ş"){
					v = v.replace("ş","Ş");
				}else if(c == "ç"){
					v = v.replace("ç","Ç");
				}else if(c == "ğ"){
					v = v.replace("ğ","Ğ");
				}else if(c == "ü"){
					v = v.replace("ü","Ü");
				}else if(c == "ö"){
					v = v.replace("ö","Ö");
				}else if(c == "ı"){
					v = v.replace("ı","I");
				}else{
					v = v.charAt(0).toUpperCase() + v.slice(1).toLowerCase();
				}
			}
			rVal = rVal + " " + v + ",";
		});
		val = rVal.trim();
		let l = val.length - 1;
		val = val.substr(0,l);
	}else{
		let c = val.substr(0,1);
		let r = capitalLetters.indexOf(c);
		if(r == -1){
			if(c == "i"){
				val = val.replace("i","İ");
			}else if(c == "ş"){
				val = val.replace("ş","Ş");
			}else if(c == "ç"){
				val = val.replace("ç","Ç");
			}else if(c == "ğ"){
				val = val.replace("ğ","Ğ");
			}else if(c == "ü"){
				val = val.replace("ü","Ü");
			}else if(c == "ö"){
				val = val.replace("ö","Ö");
			}else if(c == "ı"){
				val = val.replace("ı","I");
			}else{
				val = val.charAt(0).toUpperCase() + val.slice(1).toLowerCase();;
			}
		}
	}
	
	return val;
}

function getName(val){
	val = val.trim();
	var characterArray = {"guvenilir" : "Güvenilir","iyikalpli" : "İyi kalpli","durust" : "Dürüst","saygili" : "Saygılı","sefkatli" : "Şefkatli","merhametli" : "Merhametli","sadakatli" :"Sadakatli","yardimsever":"Yardımsever","hosgorulu":"Hoşgörülü","neseli":"Neşeli","fedakar":"Fedakâr","vefali":"Vefalı","adaletli":"Adaletli","sevimli":"Sevimli","guleryuzlu":"Güleryüzlü","duyarli":"Duyarlı","dogal":"Doğal","arkadascanlisi":"Arkadaş canlısı","ahlakli":"Ahlaklı","anlayisli":"Anlayışlı","gorgulu":"Görgülü","azimli":"Azimli","eglenceli":"Eğlenceli","esnek":"Esnek","acikfikirli":"Açık fikirli","etkileyici":"Etkileyici","akilli":"Akıllı","comert":"Cömert","iyimser":"İyimser","dikkatli":"Dikkatli","zeki":"Zeki","sabirli":"Sabırlı","kulturlu":"Kültürlü","alcakgonullu":"Alçak gönüllü","becerikli":"Becerikli","nazik":"Nazik","enerjik":"Enerjik","mantikli":"Mantıklı","bilgili":"Bilgili","uyumlu":"Uyumlu","duzenli":"Düzenli","dakik":"Dakik","caliskan":"Çalışkan","basarili":"Başarılı","sempatik":"Sempatik","zarif":"Zarif","insafli":"İnsaflı","esprili":"Esprili","coskulu":"Coşkulu","yapici":"Yapıcı","yetenekli":"Yetenekli","prensipli":"Prensipli","dusunceli":"Düşünceli","yenilikci":"Yenilikçi","medeni":"Medeni","cevik":"Çevik","sosyal":"Sosyal","guclu":"Güçlü","girisken":"Girişken","agirbasli":"Ağırbaşlı","gercekci":"Gerçekçi","istikrarli":"İstikrarlı","cekici":"Çekici","aktif":"Aktif","duygusal":"Duygusal","delidolu":"Deli dolu","ozgur":"Özgür","ozgun":"Özgün","romantik":"Romantik","asil":"Asil","sanatkar":"Sanatkar","maceraci":"Maceracı","farkli":"Farklı","gozupek":"Gözüpek","tutumlu":"Tutumlu","disadonuk":"Dışa dönük","atilgan":"Atılgan","temkinli":"Temkinli","siradisi":"Sıradışı","siradan":"Sıradan","konuskan":"Konuşkan","hirsli":"Hırslı","ciddi":"Ciddi","entelektüel":"Entelektüel","titiz":"Titiz","muzip":"Muzip","hayalperest":"Hayalperest","rahat":"Rahat","sorgulayici":"Sorgulayıcı","hazircevap":"Hazırcevap","cocuksu":"Çocuksu","mukemmelliyetci":"Mükemmelliyetçi","geleneksel":"Geleneksel","itaatkar":"İtaatâr","utangac":"Utangaç","sessiz":"Sessiz","muhafazakar":"Muhafazakar","havali":"Havalı","inatci":"İnatçı","cekingen":"Çekingen","suskun":"Suskun","kuskucu":"Kuşkucu","supheci":"Şüpheci","tanimsiz":"Tanımsız"};
	return characterArray[val];
} 

function listArray(arr,order){

	// dizideki tekrar eden elemanları sayı adedine toplayıp yeni obj olusturuyoruz
	var itemCount = [];
	arr.forEach(function (x) { itemCount[x] = (itemCount[x] || 0) + 1; });
	
	// olusturdugumuz objeyi ters siralamak icin diziye donusturuyoruz.
	var countsSortable = [];
	for (var i in itemCount) {
		countsSortable.push([i])
	}
			
	return countsSortable;
		
}

function kopyala(element){
	var sound = new Audio('sounds/beep.wav');
	sound.play();
	var alan = document.querySelector(element).innerHTML;
	var textAlani = document.createElement("TEXTAREA");
	textAlani.value = alan;
	document.body.appendChild(textAlani);
	textAlani.select();
	document.execCommand("copy"); 
	textAlani.style.display = "none";
	toastr["success"]("Başarıyla kopyalandı."); 
}

function okCookie(){
	$.ajax({
		type: 'POST',
		url: 'process.php',
		data: 'okCookie=ok',
		success: function(result){
			$(".cookie").css("display","none");
		}
	})
}
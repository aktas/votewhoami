<?php 

namespace votewhoami\db;
class database{
	private $MYSQL_HOST = 'localhost';
	private $MYSQL_USER = 'root';
	private $MYSQL_PASS = '';
	private $MYSQL_DB = 'votewhoa_votewhoami';
	private $CHARSET = 'UTF8';
	private $COLLATION = 'utf8_general_ci';
	private $pdo = null;
	private $stmt = null;

	private function connectDb(){ # DATABASE CONNECTION
		$SQL = "mysql:host=".$this->MYSQL_HOST.";dbname=".$this->MYSQL_DB;
		try{
			$this->pdo = new \PDO($SQL,$this->MYSQL_USER,$this->MYSQL_PASS);
			$this->pdo->exec("SET NAMES '".$this->CHARSET."' COLLATE '".$this->COLLATION."'");
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ); #FETCH_NUM ‘da yapılabilir. Yapılır ise 0 1 2 olarak listelenir anahtarlar ve öyle çekilir. FETCH_OBJ ’ de kullanılabilir.OBJ kullanılır ise $items->id şeklinde çekilir 
		}catch(PDOException $e){
			die("Veri tabanına ulaşılamadı".$e->getMessage());
		}
	}

	public function __construct(){ # DATABASE CONNECTION START
		$this->connectDb();
	}

	private function myQuery($query,$params=null){ # Diğer metodlardaki tekrarlı verileri bitirmek için kullanılan metod
		if(is_null($params)){
			$this->stmt = $this->pdo->query($query);
		}else{
			$this->stmt = $this->pdo->prepare($query);
			$this->stmt->execute($params);
		}
		return $this->stmt;
	}

	public function Limit($query,$p1=1,$p2=NULL){
		$this->stmt = $this->pdo->prepare($query);
		$this->stmt->bindParam(1,$p1,\PDO::PARAM_INT);
		if(!is_null($p2))
			$this->stmt->bindParam(2,$p2,\PDO::PARAM_INT);
		$this->stmt->execute();
		return $this->stmt->fetchAll();
	}

	public function Like($query,$l,$p1=NULL,$p2=NULL){
		$this->stmt = $this->pdo->prepare($query);
		$l = "%".$l."%";
		if(is_null($p1)){
			$this->stmt->bindParam(1,$l);
		}else{
			$this->stmt->bindParam(1,$l);
			$this->stmt->bindParam(2,$p1,\PDO::PARAM_INT);
			if(!is_null($p2))
				$this->stmt->bindParam(3,$p2,\PDO::PARAM_INT);
		}
		$this->stmt->execute();
		return $this->stmt->fetchAll();
	}

	public function getRows($query,$params=null){ # Çoklu Satır
		try{
			return $this->myQuery($query,$params)->fetchAll();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function getRow($query,$params=null){ # Tekli Satır
		try{
			return $this->myQuery($query,$params)->fetch();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function getColumn($query,$params=null){ # Tek Satırdaki Tek Sütun
		try{
			return $this->myQuery($query,$params)->fetchColumn();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function Insert($query,$params){
		try{
			$this->myQuery($query,$params);
			return $this->pdo->lastInsertId();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function Update($query,$params=null){ 
		try{
			return $this->myQuery($query,$params)->rowCount();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function Delete($query,$params=null){ // Tek Satırdaki Tek Sütun
		return $this->Update($query,$params);
	}

	public function __destruct(){ # DATABASE CONNECTION END
		$this->pdo = NULL;
	}
} # namespace klasör adıyla, class adı ise dosya adıyla aynı olacak. $db = new \ders\db\database(); şeklinde bağlanıyor. Db klasör adı oluyor.

# $select = $db->getRow("SELECT MemberName, MemberAge FROM members WHERE Id = ?",array($id)); şeklinde veriler çekilir!

# insert işleminde eklenme başarılı ise son id, başarısız ise 0 döner.

# update ve delete işlemlerinde güncellenen satırları sayar ve döndürür. 0 ise güncellenememiş demektir.

# Limit kullanılırken $select = $db->getRow("SELECT * FROM members ORDER BY id ASC LIMIT ?",10); şeklinde kullanılır. İkinci değer verilir ise aralığı getirir.

# ORDER BY id ASC baştan sıralar ORDER BY id DESC sondan sıralar

# like kullanımı örnek: $select = $db->Like("SELECT * FROM aaaa WHERE aas LIKE ? LIMIT ?,?","ö",0,1);

# COUNT ile sonucu saydırmak istersek örnek kullanım: $select = $db->Like("SELECT COUNT(*) as num FROM aaaa WHERE aas LIKE ? LIMIT ?,?","ö",0,1); şeklinde COUNT(*) as num yaz. Daha sonra $select[0]->num ile sonucu çekiyoruz. Ya da count($select) ile yazdırabiliriz. 

# Min Max Avg(ortalama) Sum(toplam) kullanımı için  $select = $db->getColumn("SELECT SUM(id) FROM aaaa"); şeklinde getColumn kullan ve echo $select ile yazdır.

# INNER JOIN kullanımı örnek: $select = $db->getRows("SELECT members.memberName, products.productName FROM members INNER JOIN products ON members.memberID = products.userID"); $select array olarak döner. Arrayin içinde nesneler vardır. members.memberName, products.productName kısmı(baş kısım. *'da koyabilirdik) neyi çekeceğimiz, from members(ana kısım), INNER JOIN products ile bağladık, ON members.memberID = products.userID kısmı ile de nasıl bağlanacaklarını belirttik. INNER JOIN kısmını LEFT JOIN yaparsak from members kısmındaki members tablosuna ait tüm verileri de getirir. RIGHT JOIN ise members kısmını değil products kısmındaki tüm verileri de getirir. Eğer üçlü bir kullanım olacak ise şu şekil bir sorgu girilir: $db->getRows("SELECT members.memberName, products.productName, comments.commentName FROM members INNER JOIN products ON members.memberID = products.userID INNER JOIN comments ON members.memberId = comments.userId AND products.productId = comments.productId"); Daha kolay kullanımı NATURAL JOIN. Örn kullanım: $db->getRows("SELECT members.memberName, products.productName FROM members NATURAL JOIN products "); NATURAL JOIN tablolarda aynı olan sütunları otomatik eşleştirir. İki Tabloda da memberId var ise otomatik eşleşir ve çekilir.

# SELECT * yazmak yerine SELECT DISTINCT yas yazılırsa yaşlarda tekrarlanan verileri getirmez getirdikleri de sadece yastır. Fakat eğer SELECT * from members GROUP BY yas yazarsak yine tekrarlanan yasları getirmez getirdiklerinde ise tüm sütunlara ulaşılabilir. GROUP BY kullanıldığında where kullanılmaz onun yerine HAVING kullanılır. ÖRN: GROUP BY age HAVING age > 10. 

# REPLACE ile bir sütunun içeriğini değiştirebiliriz. ÖRN: UPDATE products SET productName = REPLACE(productName,"merhaba","hello"). 

# Koşullu İfadeler. SELECT CASE WHEN MemberCity IS NULL 'Şehir Verisi YOk' ELSE 'Şehir Verisi Var' END AS MyCity from members. Bu sorgu ile şehir verisi var mı yok mu kontrol ettik ve MyCity değişkenine attık. SELECT CASE WHEN age <= 33 THEN 'GENÇ' WHEN age > 33 AND age < 50 THEN 'ORTA' ELSE 'YAŞLI' END AS myAge FROM members. Bu sorgu ile çoklu kontrol yaptık. 

?>
<?php 

namespace votewhoami\graphics;

class languages extends \votewhoami\db\database{
	public $tr = 0;
	public $en = 0;
	public $other = 0;

	public function getLanguages(){
		$select = parent::Like("SELECT COUNT(visitorsLanguage) as num FROM visitors WHERE visitorsLanguage LIKE ?","tr");
		$this->tr = $select[0]->num;

		$select = parent::Like("SELECT COUNT(visitorsLanguage) as num FROM visitors WHERE visitorsLanguage LIKE ?","en");
		$this->en = $select[0]->num;

		$select = parent::Like("SELECT COUNT(visitorsLanguage) as num FROM visitors WHERE visitorsLanguage LIKE ?","other");
		$this->other = $select[0]->num;
		
		$array = array($this->tr,$this->en,$this->other);
		return $array;
	}
	
}


?>
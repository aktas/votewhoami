<?php 

namespace votewhoami\graphics;

class messages extends \votewhoami\db\database{
	public $num = 0;

	public function getAllMessages(){
		$select = parent::getRows("SELECT * from messages");
		$this->num = count($select);
		return $this->num;
	}
}

?>
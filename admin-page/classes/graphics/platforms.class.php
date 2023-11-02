<?php 

namespace votewhoami\graphics;

class platforms extends \votewhoami\db\database{
	public $linux = 0;
	public $windows = 0;
	public $mac = 0;
	public $other = 0;

	public function getPlatforms(){
		$select = parent::Like("SELECT COUNT(visitorsPlatform) as num FROM visitors WHERE visitorsPlatform LIKE ?","linux");
		$this->linux = $select[0]->num;

		$select = parent::Like("SELECT COUNT(visitorsPlatform) as num FROM visitors WHERE visitorsPlatform LIKE ?","windows");
		$this->windows = $select[0]->num;

		$select = parent::Like("SELECT COUNT(visitorsPlatform) as num FROM visitors WHERE visitorsPlatform LIKE ?","mac");
		$this->max = $select[0]->num;

		$select = parent::Like("SELECT COUNT(visitorsPlatform) as num FROM visitors WHERE visitorsPlatform LIKE ?","other");
		$this->other = $select[0]->num;
		
		$array = array($this->linux,$this->windows,$this->mac,$this->other);
		return $array;
	}
	
}


?>
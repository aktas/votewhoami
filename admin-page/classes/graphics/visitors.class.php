<?php 

namespace votewhoami\graphics;

class visitors extends \votewhoami\db\database{
	public $visitors1 = 0;
	public $visitors2 = 0;
	public $visitors3 = 0;
	public $visitors4 = 0;
	public $visitors5 = 0;
	public $visitors6 = 0;

	public function getVisitors(){
		$date = date("Y-m");
		$select = parent::Like("SELECT * FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->visitors1 = count($select);
		
		$date = date('Y-m',strtotime('-1 month'));
		$select = parent::Like("SELECT * FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->visitors2 = count($select);

		$date = date('Y-m',strtotime('-2 month'));
		$select = parent::Like("SELECT * FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->visitors3 = count($select);

		$date = date('Y-m',strtotime('-3 month'));
		$select = parent::Like("SELECT * FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->visitors4 = count($select);

		$date = date('Y-m',strtotime('-4 month'));
		$select = parent::Like("SELECT * FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->visitors5 = count($select);

		$date = date('Y-m',strtotime('-5 month'));
		$select = parent::Like("SELECT * FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->visitors6 = count($select);

		$array = array($this->visitors1,$this->visitors2,$this->visitors3,$this->visitors4,$this->visitors5,$this->visitors6);
		return $array;
	}

	public function getAllVisitors(){
		$select = parent::getRows("SELECT * from visitors");
		return count($select);
	}

	
}


?>
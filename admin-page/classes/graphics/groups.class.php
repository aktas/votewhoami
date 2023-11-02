<?php 

namespace votewhoami\graphics;

class groups extends \votewhoami\db\database{
	public $num = 0;
	public $groups1 = 0;
	public $groups2 = 0;
	public $groups3 = 0;
	public $groups4 = 0;
	public $groups5 = 0;
	public $groups6 = 0;

	public function getAllGroups(){
		$select = parent::getRows("SELECT * from groups");
		$this->num = count($select);
		
		return $this->num;
	}

	public function getGroups(){
		$date = date("Y-m");
		$select = parent::Like("SELECT * FROM groups WHERE groupDate LIKE ?",$date);
		$this->groups1 = count($select);
		
		$date = date('Y-m',strtotime('-1 month'));
		$select = parent::Like("SELECT * FROM groups WHERE groupDate LIKE ?",$date);
		$this->groups2 = count($select);

		$date = date('Y-m',strtotime('-2 month'));
		$select = parent::Like("SELECT * FROM groups WHERE groupDate LIKE ?",$date);
		$this->groups3 = count($select);

		$date = date('Y-m',strtotime('-3 month'));
		$select = parent::Like("SELECT * FROM groups WHERE groupDate LIKE ?",$date);
		$this->groups4 = count($select);

		$date = date('Y-m',strtotime('-4 month'));
		$select = parent::Like("SELECT * FROM groups WHERE groupDate LIKE ?",$date);
		$this->groups5 = count($select);

		$date = date('Y-m',strtotime('-5 month'));
		$select = parent::Like("SELECT * FROM groups WHERE groupDate LIKE ?",$date);
		$this->groups6 = count($select);

		$array = array($this->groups1,$this->groups2,$this->groups3,$this->groups4,$this->groups5,$this->groups6);
		return $array;
	}
}

?>
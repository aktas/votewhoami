<?php 

namespace votewhoami\graphics;

class views extends \votewhoami\db\database{

	public $month1 = 0;
	public $month2 = 0;
	public $month3 = 0;
	public $month4 = 0;
	public $month5 = 0;
	public $month6 = 0;
	public $month7 = 0;
	public $month8 = 0;
	public $month9 = 0;
	public $month10 = 0;
	public $month11 = 0;
	public $month12 = 0;

	public function getViews(){

		$date = date("Y-m");
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month1 = $select[0]->num;

		$date = date("Y-m",strtotime('-1 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month2 = $select[0]->num;

		$date = date("Y-m",strtotime('-2 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month3 = $select[0]->num;

		$date = date("Y-m",strtotime('-3 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month4 = $select[0]->num;

		$date = date("Y-m",strtotime('-4 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month5 = $select[0]->num;

		$date = date("Y-m",strtotime('-5 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month6 = $select[0]->num;

		$date = date("Y-m",strtotime('-6 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month7 = $select[0]->num;

		$date = date("Y-m",strtotime('-7 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month8 = $select[0]->num;

		$date = date("Y-m",strtotime('-8 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month9 = $select[0]->num;

		$date = date("Y-m",strtotime('-9 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month10 = $select[0]->num;

		$date = date("Y-m",strtotime('-10 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month11 = $select[0]->num;

		$date = date("Y-m",strtotime('-11 month'));
		$select = parent::Like("SELECT SUM(visitorsClick) as num FROM visitors WHERE visitorsDate LIKE ?",$date);
		$this->month12 = $select[0]->num;

		$array = array($this->month1,$this->month2,$this->month3,$this->month4,$this->month5,$this->month6,$this->month7,$this->month8,$this->month9,$this->month10,$this->month11,$this->month12);

		return $array;
		
	}

	public function getAllViews(){
		$num = parent::getColumn("SELECT SUM(visitorsClick) FROM visitors");
		return $num;
	}
}


?>
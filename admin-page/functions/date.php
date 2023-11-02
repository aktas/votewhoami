<?php 

function getMonths(){
	$months = array();
	array_push($months,date("M"),date("M",strtotime("-1 month")),date("M",strtotime("-2 month")),date("M",strtotime("-3 month")),date("M",strtotime("-4 month")),date("M",strtotime("-5 month")),date("M",strtotime("-6 month")),date("M",strtotime("-7 month")),date("M",strtotime("-8 month")),date("M",strtotime("-9 month")),date("M",strtotime("-10 month")),date("M",strtotime("-11 month")));
	return $months;
}


?>
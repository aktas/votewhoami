<?php 

ob_start();

function go($where,$type=null,$statu=null){
	if(is_null($type) and is_null($val)){
		header("Location:$where");
		exit;
	}else{
		header("Location:$where-$type-$statu");
		exit;
	}
}

?>
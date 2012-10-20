<?php
require_once 'dao/GareDao.php';

class ListeGaresJson extends AController{
	
	function GET($matches){
		echo $this->listeGares();
	}
	
	function PUT($matches){
		throw new Exception("Don't PUT this resource. You're probably trying something nasty.");
	}
	
	function DELETE($matches){
		throw new Exception("Don't DELETE this resource. You're probably trying something nasty.");
	}
	
	function POST($matches){
		throw new Exception("Don't POST this resource. You're probably trying something nasty.");
	}
	
	function listeGares(){
		
		$gareDao = new GareDAO();
		
		$array = $gareDao->getGares();
		return json_encode($array);
	}
	
}




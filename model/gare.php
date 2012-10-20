<?php

class Gare {
    var $id_gare;
    var $nom_gare;
       
    public function __construct($id, $nom) {
        $this->$id_gare = $id;
        $this->$nom_gare = $nom;
    }
    
	
	function getId(){
		return $this->$id_gare;
	}
	
	function setId($id){
		$this->$id_gare = $id;
	}
	
	function getNom(){
		return $this->$nom_gare;
	}
	
	function setNom($nom){
		$this->$nom_gare = $nom;
	}
}

?>
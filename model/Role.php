<?php
class Role {
	
	var $id_role;
	var $nom_role;
	var $lbl_role;
	var $img_role;
    
    public function __construct($id, $nom, $label, $img) {
        $this->$id_role = $id;
        $this->$nom_role = $nom;
        $this->$lbl_role = $label;
        $this->$img_role = $img;
    }
	
	function getId(){
		return $this->id_role;
	}
	
	function setId($id){
		$this->id_role = $id;
	}
	
	function getNom(){
		return $this->nom_role;
	}
	
	function setNom($nom){
		$this->nom_role =  $nom;
	}
	
	function getLbl(){
		return $this->lbl_role;
	}
	
	function setLbl($lbl){
		$this->lbl_role =  $lbl;
	}
	
	function getImg(){
		return $this->img_role;
	}
	
	function setImg($fileName){
		$this->img_role =  $fileName;
	}
	
}

?>
<?php

class User {
	
	// Definition des variables
	
	// Id de l'utilisateur
	var $id_user; 
	
	// Login de l'utilisateur
	var $login;
	
	// Password de l'utilisateur
	var $password;
	
	// Email de l'utilisateur
	var $email;
	
	// Nombre de messages
	var $nb_message;
	
	// Nombre de plus
	var $nb_ok;
	
	// Date de l'inscription
	var $date_inscription;
	
	// Role
	var $role;
	
	function getId(){
		return $this->id_user;
	}
	
	function setId($id){
		$this->id_user = $id;
	}
	
	function getLogin(){
		return $this->login;
	}
	
	function setLogin($login){
		$this->login = $login;
	}
	
	function getPassword(){
		return $this->password;
	}
	
	function setPassword($password){
		$this->password = $password;
	}
	
	function getEmail(){
		return $this->email;
	}
	
	function setEmail($email){
		$this->email = $email;
	}
	
	function getNbMessages(){
		return $this->nb_message;
	}
	
	function getNbMsgOk(){
		return $this->nb_ok;
	}
	
	function setDateInscription($date_inscription){
		$this->date_inscription = $date_inscription;
	}
	
	function getDateInscription(){
		return $this->date_inscription;
	}
	
	function setRole($role){
		$this->role = $role;
	}
	
	function getRole(){
		return $this->role;
	}
	
	// function addMsg
}

?>
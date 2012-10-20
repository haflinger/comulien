<?php

require_once '../model/User.php';
require_once '../model/dbConnect.php';

function getUserById($id){
	$connexion = dbConnect::getInstance();
	
	$array = $connexion->ExecuteSelect('SELECT * FROM user WHERE IDUSER =' . $id );

//	$user = new User();
//	$user->init($sql['IDUSER'], $sql['IDROLE'], $sql['LOGIN'], $sql['PASSWORD'], $sql['NBMESSAGE'], $sql['NBOK'], $sql['IDROLE']);

	
	return $array;

}

function getAllUsers(){
	return array();
}
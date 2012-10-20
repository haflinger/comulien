<?php

require_once '../model/User.php';
require_once '../model/dbConnect.php';

function getUserById($id){
	$connexion = dbConnect::getInstance(); // A supprimer
	
	$array = $connexion->ExecuteSelectOne('SELECT * FROM user WHERE IDUSER =' . $id );

	return new User ($array['IDUSER'], $array['LOGIN'], $array['PASSWORD'], $array['EMAIL'], $array['NBMESSAGE'], $array['NBOK'], $array['IDROLE']);
}

function getAllUsers(){
	$connexion = dbConnect::getInstance(); // A supprimer
	
	$array = $connexion->ExecuteSelect('SELECT * FROM user');
	
	for ($i= 0; $i < count($array); $i++){
		$u_array = $array[$i];
		$user = new User ($u_array['IDUSER'], $u_array['LOGIN'], $u_array['PASSWORD'], $u_array['EMAIL'], $u_array['NBMESSAGE'], $u_array['NBOK'], $u_array['IDROLE']);
		$list[] = $user;
	}
	
	return $list;
}
<?php

require_once '../model/User.php';
require_once '../model/dbConnect.php';

function getUserById($id){
	$connexion = dbConnect::getInstance();
	$user = self::$connexion->ExecuteSelect('SELECT iduser,idrole,login,password,email,nbmessage,nbok,dateinscription FROM user WHERE id=' . $id );
	return $user;
}

function getAllUsers(){
	return array();
}
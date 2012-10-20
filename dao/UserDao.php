<?php

require_once(MODELEPATH . 'user.php');
require_once(MODELEPATH . 'dbConnect.php');

function getUserById($id){
        $connexion = dbConnect::getInstance();
        $array = $connexion->ExecuteSelectOne('SELECT * FROM user WHERE IDUSER =' . $id );
	return new User ($array['IDUSER'], $array['LOGIN'], $array['PASSWORD'], $array['EMAIL'], $array['NBMESSAGE'], $array['NBOK'], $array['IDROLE']);
}

function isCheminot($id){
    $connexion = dbConnect::getInstance();
    $array = $connexion->ExecuteSelectOne('SELECT * FROM user WHERE IDUSER =' . $id );
    if ($array['IDROLE'] == 2 || $array['IDROLE'] == 3){
        return true;
    }else{
        return false;
    }  
}

function getAllUsers(){
	$connexion = dbConnect::getInstance();
	$array = $connexion->ExecuteSelect('SELECT * FROM user');
	foreach ($array as $u_array)
	{
		$user = new User ($u_array['IDUSER'], $u_array['LOGIN'], $u_array['PASSWORD'], $u_array['EMAIL'], $u_array['NBMESSAGE'], $u_array['NBOK'], $u_array['IDROLE']);
		$list[] = $user;
	}	
	return $list;
}

function createUser($idrole, $login, $pass, $mail){
     $connexion = dbConnect::getInstance();
     $tabData = array();
     $tabData['IDROLE'] = $idrole;
     $tabData['LOGIN'] = $login;
     $tabData['PASSWORD'] = md5($pass);
     $tabData['EMAIL'] = $mail;
     $tabData['NBMESSAGE'] = 0;
     $tabData['NBOK'] = 0;
     $tabData['DATEINSCRIPTION'] = time();
     $connexion->ExecuteInsert('INSERT INTO user(IDROLE, LOGIN, PASSWORD, EMAIL, NBMESSAGE, NBOK, DATEINSCRIPTION) VALUES (:IDROLE, :LOGIN, :PASSWORD, :EMAIL, :NBMESSAGE, :NBOK, :DATEINSCRIPTION)', $tabData);
}

function matchUser($login, $pass){
    $connexion = dbConnect::getInstance();
    $array = $connexion->ExecuteSelectOne('SELECT * FROM user WHERE LOGIN ="' . $login . '" AND PASSWORD ="' . md5($pass) . '"');

    if(!empty($array[0])){
        return new User ($array['IDUSER'], $array['LOGIN'], $array['PASSWORD'], $array['EMAIL'], $array['NBMESSAGE'], $array['NBOK'], $array['IDROLE']);
    }else{
        return FALSE;
    }

}

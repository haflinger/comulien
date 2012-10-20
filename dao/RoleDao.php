<?php
require_once '../model/Role.php';
require_once(MODELEPATH . 'dbConnect.php');

function getRoleById($id){
    $connexion = dbConnect::getInstance();
    $roleSQL = $connexion->ExecuteSelectOne('SELECT * FROM role WHERE IDROLE = '.$id);
    $role = new Role($roleSQL['IDROLE'], $roleSQL['LBLROLE'], $roleSQL['TYPEROLE'], $roleSQL['IMAGEROLE']);
    return $role;
}
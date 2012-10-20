<?php
require_once '../model/Role.php';

function getRoleById($id){
    $roleSQL = self::$connexion->ExecuteSelectOne('SELECT * FROM role WHERE IDROLE = '.$id);
    $role = new Role($roleSQL['IDROLE'], $roleSQL['LBLROLE'], $roleSQL['TYPEROLE'], $roleSQL['IMAGEROLE']);
    return $role;
}
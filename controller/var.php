<?php
session_start();
define ("MODELEPATH", 'model/');
define ("CONTROLPATH", 'controler/');
define ("CONTROLERSPATH", 'controlers/');
define ("VUEPATH", 'view/');
define ("DAO", 'dao/');

require_once (MODELEPATH . 'dbConnect.php');
$connexion = dbConnect::getInstance();
?>

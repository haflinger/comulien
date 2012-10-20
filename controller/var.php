<?php
session_start();
define ("MODELEPATH", 'model/');
define ("CONTROLPATH", 'controler/');
define ("CONTROLERSPATH", 'controlers/');
define ("VUEPATH", 'view/');

require_once ('../controller/dbConnect.php');

$connexion = dbConnect::getInstance();
?>

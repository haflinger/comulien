<?php

define ("MODELEPATH", 'model/');
define ("CONTROLPATH", 'controler/');
define ("CONTROLERSPATH", 'controlers/');
define ("VUEPATH", 'view/');

require_once (MODELEPATH . 'dbConnect.php');

$connexion = dbConnect::getInstance();
?>

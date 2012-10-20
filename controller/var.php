<?php

define ("MODELEPATH", 'model/');
define ("CONTROLPATH", 'controler/');
define ("VUEPATH", 'view/');

require_once (CLASSPATH . 'dbConnect.php');

$connexion = dbConnect::getInstance();
?>

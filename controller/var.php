<?php
session_start();
define ("MODELEPATH", '../model/');
define ("CONTROLPATH", 'controller/');
define ("CONTROLERSPATH", 'controllers/');
define ("VUEPATH", 'view/');
define ("DAO", 'dao/');

require_once (MODELEPATH . 'dbConnect.php');
$connexion = dbConnect::getInstance();
?>

<?php
require_once ('../controller/var.php');
require_once ('../dao/messageDao.php');

$test = listeMessageParent(1);

var_dump($test);

?>
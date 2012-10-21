<?php
require_once ('../controller/var.php');
require_once ('../dao/messageDao.php');
require_once ('../model/message.php');
$liste = listeMessageParent(1);

var_dump($liste);
?>
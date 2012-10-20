<?php

require_once '../controller/var.php';
require_once '../dao/messagesDao.php';
require_once '../model/message.php';
$test = listeMessageParent(1);

var_dump($test);

?>
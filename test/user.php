<?php
require_once 'dao/UserDao.php';

$user = getUserById(2);

echo print_r($user);

?>
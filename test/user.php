<?php

require_once '../model/dbConnect.php';

require_once '../dao/UserDao.php';

$user = getUserById(1);

print_r($user);


?>
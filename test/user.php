<?php

require_once('../controller/var.php');
require_once('../model/dbConnect.php');
require_once('../dao/UserDao.php');
require_once('../model/user.php');

print_r(getAllUsers());
createUser(3, 'Frederic', 'bob', 'mail@sncf.fr');
print_r(getAllUsers());

?>
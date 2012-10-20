<?php

require_once '../model/dbConnect.php';

require_once '../dao/UserDao.php';

print_r(getUserById(2));
print_r(getAllUsers());


?>
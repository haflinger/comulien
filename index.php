<?php
//Added this as a temporary solution to make the link with view.

//Over here the "router" should be written: a file which checks every URI and redirects it to the right Controller (in the MVC model)

// This file is not being used anymore if you've set up mod rewrite on your server.
// TODO:
//  * #a2enmod rewrite
//  * edit the file /etc/apache2/site-available/default.conf (or something like this) and change Allow Override on your /var/www dir to "All"
//  * restart your server: apache2ctl restart 

include_once("view/index.php");

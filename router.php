<?php
/**
 * This file is the router. It's where all calls come in. It will accept a request en refer it to the right Controller
 *
 * @author Pieter Colpaert
 */
include_once('lib/glue.php');
include_once('controllers/AController.class.php');
include_once('Config.class.php');
// Time is always in UTC
date_default_timezone_set('UTC');

//When do class could not be found, try to autoload in root
function __autoload($class){
    if(file_exists($class . ".class.php")){
        include_once($class . ".class.php");
    }else if(file_exists("controllers/" . $class . ".class.php")){
        include_once("controllers/" . $class . ".class.php");
    }
}

//map urls to a classname
//using regular expression. If you don't know these, I'm nearby!
$urls = array(
    "/" => "Index",
  "/logging" => "ControllerLogging", //example of a new line
    "/(.+)" => "AController"
);

//This function will do the magic. See includes/glue.php
try {
    glue::stick($urls);
} 
catch(Exception $e){
    echo "Zut, j'ai fait un erreur: " . $e;
}

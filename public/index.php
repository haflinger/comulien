<?php

// Define path to application directory
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/../library'),
            get_include_path(),
        )));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);

$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production');
$registry = Zend_Registry::getInstance();
$registry->set('config', $config);


// Bootsy - C'est ici qu'on définit l'adapter par defaut. on va chercher les infos dans le ficher de configs/application.ini
$db = Zend_Db::factory($config->database->adapter, array(
            'host'              => $config->database->params->host,
            'username'          => $config->database->params->username,
            'password'          => $config->database->params->password,
            'dbname'            => $config->database->params->dbname,
            // j'ai rajouté ces infos pour être sur que tout part en utf8 dans la base       
            'charset'           => 'utf8',
            'driver_options'    => array('1002' => 'SET NAMES utf8')
                )
);

// placons la connexion dans un registre global à l'application
//$registry = Zend_Registry::getInstance(); // alex - la variable $registry est déclarée 2 fois
$registry->set('db', $db);

// en faire la connexion par defaut
Zend_Db_Table::setDefaultAdapter($db);

$application->bootstrap()
        ->run();
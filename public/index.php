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

$config = new Zend_Config(
                array(
                    'db' => array(
                        'adapter' => 'PDO_MYSQL',
                        'params' => array(
                            'host' => 'localhost',
                            'dbname' => 'comulien',
                            'username' => 'root',
                            'password' => '',
                            'charset' => 'utf8',
                            'driver_options' => array('1002' => 'SET NAMES utf8')
                        )
                    )
                )
);


$db = Zend_Db::factory($config->db);
Zend_Db_Table::setDefaultAdapter($db);

$application->bootstrap()
        ->run();
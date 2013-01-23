<?php
//pour afficher plus d'erreurs
error_reporting(E_ALL|E_STRICT);

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
        array(
            'config' => array(
                APPLICATION_PATH . '/configs/application.ini',
                APPLICATION_PATH . '/configs/db.ini'
            )
        )
    
);
//lancement de la session
//Zend_Session::start();

//Enregistrement du plugin de gestion de l'évènement
Zend_Controller_Front::getInstance()->registerPlugin(new Application_Plugin_EvenementPlugin());


//lancement du bootstrap
$application->bootstrap()
            ->run();
?>
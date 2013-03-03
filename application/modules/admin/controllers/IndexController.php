<?php

class Admin_IndexController extends Zend_Controller_Action
{

    private $_logger;
    
    public function init()
    {
        $this->_logger = Zend_Registry::get("cml_logger");
        $this->_logger->err('Arrivée dans le module admin...');
    }

    public function indexAction()
    {
        // action body
        $form = new Application_Form_Example();
        $this->view->form = $form;
    }

    public function testAction()
    {
        $this->view->test = "ceci est un message de test dans le controlleur index du module admin";
    }

}


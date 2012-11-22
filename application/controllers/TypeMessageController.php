<?php

class TypeMessageController extends Zend_Controller_Action
{
    
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $types = new Application_Model_DbTable_TypeMessage();
        $this->view->typesMessages = $types->fetchAll();
    }
    
 

}


<?php

class TypemessageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $typemessage = new Application_Model_DbTable_Typemessage();
        $this->view->entries = $typemessage->fetchAll();
    }


}


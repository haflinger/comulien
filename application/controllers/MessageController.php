<?php

class MessageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $Message = new Application_Model_MessageMapper();
        $this->view->entries = $Message->fetchAll();
    }


}


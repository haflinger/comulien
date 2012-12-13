<?php

/**
 * Description of MessageController
 *
 * @author Fred H
 */
class MessageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $Message = new Application_Model_DbTable_Message();
        $this->view->entries = $Message->fetchAll();
    }


}


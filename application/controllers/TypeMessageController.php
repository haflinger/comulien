<?php

/**
 * Description of TypeMessageController
 *
 * @author Fred H
 */

class TypeMessageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $typeMessage = new Application_Model_DbTable_TypeMessage();
        $this->view->entries = $typeMessage->fetchAll();
    }


}


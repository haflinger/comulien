<?php

/**
 * Description of OrganismeController
 *
 * @author Fred H
 */
class OrganismeController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $organisme = new Application_Model_DbTable_Organisme();
        $this->view->entries = $organisme->fetchAll();
    }


}


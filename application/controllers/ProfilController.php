<?php

class ProfilController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $profils = new Application_Model_DbTable_Profil();
        $this->view->profils = $profils->fetchAll();
    }


}


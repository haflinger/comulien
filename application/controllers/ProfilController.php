<?php

class ProfilController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $Profil = new Application_Model_ProfilMapper();
        $this->view->entries = $Profil->fetchAll();
    }


}


<?php

/**
 * Description of UtilisateurController
 *
 * @author Fred H
 */
class UtilisateurController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $Utilisateur = new Application_Model_DbTable_Utilisateur();
        $this->view->entries = $Utilisateur->fetchAll();
    }
    

}


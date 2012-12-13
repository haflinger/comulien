<?php

/**
 * Description of EvenementController
 *
 * @author Fred H
 */
class EvenementController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
    
    /*
     * Connexion à un événement par une URL, un QrCode....
     * C'est le point d'entrée de l'application !
     */
    public function indexAction()
    {
        //Connexion à un événement
        $Evenement = new Application_Model_DbTable_Evenement();
        $this->view->entries = $Evenement->fetchAll();
    }


}


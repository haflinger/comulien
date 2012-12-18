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
    
    public function checkinAction()
    {
        // site/evenement/checkin/id/1
        // ou
        // site/evenement/checkin/1
        //TODO : tester les dates de début et de fin de validité de l'évènement
        $idEvent = $this->getRequest()->getParam('id');
        if($idEvent!=null){ 
            $Evenement = new Application_Model_DbTable_Evenement();
            $eventRowSet = $Evenement->find($idEvent);
            $eventDeID = $eventRowSet->current();
            //TODO tester la validité de l'évènement
            //...
            //Sauve l'évènement dans la session
            $defaultNamespace = new Zend_Session_Namespace('Comulien');
            $defaultNamespace->checkedInEvent = $eventDeID;
            
            $this->view->evenement = $eventDeID;
            
        } else { 
            $this->view->evenement = null;
            
        }
    }
    
    public function checkoutAction()
    {
        $defaultNamespace = new Zend_Session_Namespace('Comulien');
        unset($defaultNamespace->checkedInEvent);
        $this->_helper->redirector ( 'index', 'index' );
    }
    
    public function messagesAction()
    {
        $idEvent = $this->getRequest()->getParam('id');
        if($idEvent!=null){ 
            $Evenement = new Application_Model_DbTable_Evenement();
            $eventRowSet = $Evenement->find($idEvent);
            $eventDeID = $eventRowSet->current();
            $this->view->messages = $eventDeID;            
        } else { 
            $this->view->messages = null;
        }
    }

}


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
    
    /**
     * index : gère la situation lors de l'arrivée dans l'évènement
     * par défaut : affiche l'accueil de l'évènement
     */
    public function indexAction()
    {
        $this->_helper->redirector ( 'accueil', 'evenement' );
    }
    
    public function accueilAction()
    {
        $defaultNamespace = new Zend_Session_Namespace('bulle');
        //session active ?
        if (!isset($defaultNamespace->checkedInEvent)) {
            $this->_helper->redirector ( 'liste', 'evenement' );
        }
        else
        {
            $this->view->evenement = $defaultNamespace->checkedInEvent;
        }
        
        
        
    }
    
    public function listeAction()
    {
        //Connexion à un événement
        $Evenement = new Application_Model_DbTable_Evenement();
        $this->view->entries = $Evenement->fetchAll();
    }
    
    /**
     * checkin est une action purement technique qui va juste procéder au test
     * du checkin dans l'évènement et à la persistance en session de l'évènement checké
     */
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
            $defaultNamespace = new Zend_Session_Namespace('bulle');
            $defaultNamespace->checkedInEvent = $eventDeID;
            
            //redirection sur l'accueil de l'évènement
            $this->_helper->redirector ( 'accueil', 'evenement' );
            
        } else { 
            //redirection sur une autre action de délestage
            //(temporairement sur la liste des évènements)
            
            $this->_helper->redirector ( 'liste', 'evenement' );
            
        }
    }
    
    public function checkoutAction()
    {
        $defaultNamespace = new Zend_Session_Namespace('bulle');
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


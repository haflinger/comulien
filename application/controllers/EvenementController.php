<?php

/**
 * Description of EvenementController
 *
 * @author Fred H
 */
class EvenementController extends Zend_Controller_Action
{
    private $event = null;
    
    public function init()
    {
        /* Initialize action controller here */
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        //session active ?
        if (isset($bulleNamespace->checkedInEvent)) {
            $this->event = $bulleNamespace->checkedInEvent;
        }
        else
        {
            $this->event = null;
            //$this->view->evenement = $bulleNamespace->checkedInEvent;
        }
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
        /**
         * action par défaut 
         * redirige vers l'action 'accueil' (accueil de l'évènement)
         */
        $this->_helper->redirector ( 'liste' );//, 'evenement' );
    }
    
    public function listeAction()
    {
        /**
         * action de test pour retourner tous les évènements
         * TODO : à supprimer ultérieurement
         */
        $Evenement = new Application_Model_DbTable_Evenement();
        $this->view->entries = $Evenement->fetchAll();
    }
     
    public function checkinAction()
    {
        /*
         * checkin est une action purement technique qui va juste procéder au test
         * du checkin dans l'évènement et à la persistance en session de l'évènement checké
         * paramètre id : l'id de l'évènement
         */
        //TODO : tester les dates de début et de fin de validité de l'évènement
        $idEvent = $this->getRequest()->getParam('id');
        if($idEvent!=null){ 
            $Evenement = new Application_Model_DbTable_Evenement();
            $eventDeID = $Evenement->getEvenementParID($idEvent);
//            $eventRowSet = $Evenement->fetchAll('idEvent='.$idEvent);//find($idEvent);
//            if ($eventRowSet->count()>0) {
//                $eventDeID = $eventRowSet->current();
//            }else{
//                $eventDeID = null;
//                $this->_helper->redirector ( 'error', 'error' );
//            }
            
            //TODO tester la validité de l'évènement
            //...
            //Sauve l'évènement dans la session
            $this->setEvent($eventDeID);
            
            
            //redirection sur l'accueil de l'évènement
            //$this->_helper->redirector ( 'accueil', 'evenement' , null );
            $this->_forward('accueil');
            //$this->_redirect('/evenement/accueil');
            
            //$this->accueilAction();
            
        } else { 
            //redirection sur une autre action de délestage
            //(temporairement sur la liste des évènements)
            
            $this->_helper->redirector ( 'liste', 'evenement' );
            
        }
    }
    
   
    public function accueilAction()
    {
        /**
         * Accueil dans l'évènement
         */
        if (!$this->event) {
            $this->_helper->redirector ( 'liste', 'evenement' );
        }
        else
        {
//            $Evenement = new Application_Model_DbTable_Evenement();
//            $eventRowSet = $Evenement->fetchAll('idEvent='.$this->event->idEvent);//find($idEvent);
//            $this->view->evenement = $eventRowSet->current();//$this->event;
            $this->view->evenement = $this->event;
        }
    }
    
     public function checkoutAction()
    {
        /*
         * checkout de l'évènement
         */
        $defaultNamespace = new Zend_Session_Namespace('bulle');
        unset($defaultNamespace->checkedInEvent);
        $this->_helper->redirector ( 'index', 'index' );
    }

    //----------------------------------------------------
    //----------------------------------------------------

    
    
    
    //TODO : A modifier : action non prévue par la navigabilité
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

    /**
     * Mémorise l'évènement fourni en paramètres dans la session
     * @param type $Evenement : l'évènement dans lequel l'utilisateur s'inscrit
     */
    private function setEvent($Evenement) {
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        $bulleNamespace->checkedInEvent = $Evenement;
        $this->event = $Evenement;
    }

}


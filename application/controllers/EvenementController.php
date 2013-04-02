<?php

/**
 * Description of EvenementController
 * 
 * @author Fred H
 *
 */

class EvenementController extends Zend_Controller_Action
{

    private $_evenement = null;

    public function init()
    {
        if(Zend_Registry::isRegistered('checkedInEvent')){
            $this->_evenement = Zend_Registry::get('checkedInEvent');
        }
    }

    /**
     * index : gère la situation lors de l'arrivée dans l'évènement
     * par défaut : affiche l'accueil de l'évènement
     *
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
        /**
         * checkin est une action purement technique qui va juste procéder au test
         * du checkin dans l'évènement et à la persistance en session de l'évènement checké
         * paramètre id : l'id de l'évènement
         */
        $idEvent = $this->getRequest()->getParam('id');
        if($idEvent!=null) { 
            $Evenement = new Application_Model_DbTable_Evenement();
            $eventDeID = $Evenement->getEvenementParID($idEvent);
            //Sauve l'évènement dans la session
            $this->setEvent($eventDeID);
            
            //redirection sur l'accueil de l'évènement
            $this->_helper->redirector ( 'accueil', 'evenement' , null );
          
        }
        else { // aucun ID d'évènement passé en paramètres
            $this->_helper->redirector ( 'liste', 'evenement' );
        }
    }

    public function accueilAction()
    {
        /**
         * Accueil dans l'évènement
         */
        //L'évènement ne doit normalement pas être null puisque géré en amont par le plugin EvenementPlugin   
        //$evenement = Zend_Registry::get('checkedInEvent');
        $this->view->evenement = $this->_evenement;
        
        $organisateur = $this->_evenement->getOrga();
        $this->view->organisateur = $organisateur;

        $helperUrl = new Zend_View_Helper_Url ( );
        
        $lienListerTous = $helperUrl->url ( array ('action' => 'lister-tous', 'controller' => 'message' ) ); 
        $this->view->lienListerTous = $lienListerTous;
        
        $lienListerOrganisateur = $helperUrl->url ( array ('action' => 'lister-organisateur', 'controller' => 'message' ) ); 
        $this->view->lienListerOrganisateur = $lienListerOrganisateur;
        
        
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

    public function creerAction()
    {
        
    }
    
    
    /**
     * Mémorise l'évènement fourni en paramètres dans la session
     * @param type $Evenement : l'évènement dans lequel l'utilisateur s'inscrit
     *
     */
    private function setEvent($Evenement)
    {
        //evènement dans la session
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        $bulleNamespace->checkedInEvent = $Evenement;
        //dans le registre
        Zend_Registry::set('checkedInEvent',$Evenement);
        //dans la donnée membre privé
        $this->_evenement = $Evenement;
        
    }

    /**
     * TODO : landing page pour informer sur un problème d'évènement
     * utilisé par le evenementPlugin pour ses redirections
     */
    public function defautAction()
    {
        $info = $this->_request->getParam('infoDefautEvenement','Désolé, vous n\'êtes pas dans un évènement');
        $this->view->message = $info;
    }


}


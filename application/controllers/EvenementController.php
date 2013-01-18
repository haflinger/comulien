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
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        //session active ?
        if (isset($bulleNamespace->checkedInEvent)) {
            $this->_evenement = $bulleNamespace->checkedInEvent;
            //  
            //lors de la sauvegarde en session le EvenementRow est sérialisé, et par sécurité passe en mode 'déconnecté'
            // pour l'utiliser à nouveau comme un objet row, il faut le reconnecter en utilisant setTable
            //http://gustavostraube.wordpress.com/2010/05/11/zend-framework-cannot-save-a-row-unless-it-is-connected/
            $this->_evenement->setTable(new Application_Model_DbTable_Evenement());
        }
        else
        {
            $this->_evenement = null;
            //$this->view->evenement = $bulleNamespace->checkedInEvent;
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
        //TODO : tester les dates de début et de fin de validité de l'évènement
        $idEvent = $this->getRequest()->getParam('id');
        if($idEvent!=null){ 
            $Evenement = new Application_Model_DbTable_Evenement();
            $eventDeID = $Evenement->getEvenementParID($idEvent);
            //Sauve l'évènement dans la session
            $this->setEvent($eventDeID);
            
            //redirection sur l'accueil de l'évènement
            $this->_helper->redirector ( 'accueil', 'evenement' , null );
          
            
        } else { // aucun ID d'évènement passé en paramètres
            $this->_helper->redirector ( 'liste', 'evenement' );
        }
    }

    public function accueilAction()
    {
        /**
         * Accueil dans l'évènement
         */
        if (!$this->_evenement) {
            $this->_helper->redirector ( 'liste', 'evenement' );
        }
        else
        {
            $evenement = $this->_evenement;
            $organisateur = $evenement->getOrga();
            //$messagesOrga = $evenement->getMessagesOrga();
            $this->view->organisateur = $organisateur;
            //$this->view->messagesOrganisateurs = $messagesOrga;
            $this->view->evenement = $evenement;
            
            $helperUrl = new Zend_View_Helper_Url ( );
            $lienListerTous = $helperUrl->url ( array ('action' => 'lister-tous', 'controller' => 'message' ) ); 
            $lienListerOrganisateur = $helperUrl->url ( array ('action' => 'lister-organisateur', 'controller' => 'message' ) ); 
//var_dump($this->getEngine());
            $this->view->lienListerTous = $lienListerTous;
            $this->view->lienListerOrganisateur = $lienListerOrganisateur;
            $comulienNamespace = new Zend_Session_Namespace('bulle');
            $this->view->event = $comulienNamespace->checkedInEvent;
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

    /**
     * Mémorise l'évènement fourni en paramètres dans la session
     * @param type $Evenement : l'évènement dans lequel l'utilisateur s'inscrit
     *
     */
    private function setEvent($Evenement)
    {
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        $bulleNamespace->checkedInEvent = $Evenement;
        $this->_evenement = $Evenement;
        
    }

    /**
     * 
     */
    public function defautAction()
    {
        $info = $this->_request->getParam('infoDefautEvenement','Désolé, vous n\'êtes pas dans un évènement');
        $this->view->message = $info;
    }


}


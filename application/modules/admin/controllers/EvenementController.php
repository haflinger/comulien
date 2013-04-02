<?php

class Admin_EvenementController extends Zend_Controller_Action {

    private $_logger;
    private $_organisme;
    private $_session;
    private $_user = null;
    
    private static $ORGANISATEUR = 1;
    private static $CORPORATE = 2;
    private static $PARTENAIRE = 3;
    

    public function init() {
        $this->_logger = Zend_Registry::get("cml_logger");
        $this->_logger->err('init du controlleur Admin_Evenement');
        
        //récupération de la session
        $this->_session = new Zend_Session_Namespace('admin');
        
        //récupération de l'organisme
        if (Zend_Registry::isRegistered('organismeAdmin')) {
            $this->_organisme = Zend_Registry::get('organismeAdmin');
        }
        $this->view->organisme = $this->_organisme;
        
        //récupération de l'utilisateur
        $this->_user = $this->getUserFromAuth();
        $this->view->user = $this->_user;
    }

    public function indexAction() {
        // action body
        
    }

    public function ajouterAction() {
        $form = new Admin_Form_Evenement();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            //
            //vérification des données
            //
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                //récupération des paramètres
                $titreEvent = $form->getValue('titreEvent');
                $descEvent = $form->getValue('descEvent');
                $fileLogo = $form->getValue('fileLogo');
                $dateDebutEvent = $form->getValue('dateDebutEvent');
                $heureDebutEvent = $form->getValue('heureDebutEvent');
                $dateFinEvent = $form->getValue('dateFinEvent');
                $heureFinEvent = $form->getValue('heureFinEvent');
                $persistenceEvent = $form->getValue('persistenceEvent');
                $numEvent = null; //TODO générer un nom court d'évènement
                
                //
                //controles de données
                //
                $error = false;
                $validatorDate = new Zend_Validate_Date();
                if (!$validatorDate->isValid($dateDebutEvent)) {
                    //date de debut non valide
                    $error = true;
                }
                if (!$validatorDate->isValid($dateFinEvent)) {
                    //date de fin non valide
                    $error = true;
                }

                //TODO : la date/heure de début doit être antérieure à la date/heure de fin (si la date de fin est renseignée
                //TODO : le titre est obligatoire
                //TODO : voir si on empêche ou pas les doublons de titre
                $validatorRecordExists = new Zend_Validate_Db_RecordExists(
                                array(
                                    'table' => 'evenement',
                                    'field' => 'titreEvent'
                                )
                );
                
                if ($validatorRecordExists->isValid($titreEvent)) {
                    // L'évènement avec $titreEvent existe déjà
                    $form->addErrors(array('eventAlreadyExists' => 'Un évènement avec ce titre existe déjà.'));
                    $error = true;
                }
                
                //
                //persistence en DB
                //
                $eventTable = new Application_Model_DbTable_Evenement();
                $eventTable->setEvent($this->_organisme->idOrga, $titreEvent, $numEvent, $descEvent, $fileLogo, $dateDebutEvent, $dateFinEvent, $persistenceEvent);
                
                
            }
        }
        
    }

    public function listerAction() {
        $lesEventsRowset = $this->_organisme->findDependentRowset('Application_Model_DbTable_Evenement');
        $this->view->events = $lesEventsRowset ;
    }

    public function modifierAction() {
        //l'utilisateur doit être Organisateur  (test obsolète si géré par les ACLs)
        //$user = new Application_Model_Row_UtilisateurRow();
        $user = $this->getUserFromAuth();
        if (is_null($user)) {
            $this->_forward('error', 'error', 'admin',array('errorMessage'=>'Vous devez être connecté !'));
        }
        
        if (is_null($this->_organisme)) {
            $this->_forward('error', 'error', 'admin',array('errorMessage'=>'Vous devez sélectionner un organisme !'));
        }
        
        $idRoleUser = $user->getDistinction($this->_organisme->idOrga);
        if ( self::$ORGANISATEUR != $idRoleUser ) {
            $this->forward('error', 'error', 'admin',array('errorMessage'=>'Vous devez être Organisateur (vous êtes'.$idRoleUser.')'));
        }
        
        $paramIdEvent = $this->getRequest()->getParam('id');
        //Validation du paramètre : doit être un entier
        $validator = new Zend_Validate_Int();
        if (! $validator->isValid($paramIdEvent)) {
            $this->_forward('error', 'error', 'admin',array('errorMessage'=>'Le Paramètre est invalide'));
        }
        
        $tableEvent = new Application_Model_DbTable_Evenement();
        $event = $tableEvent->getEvenementParID($paramIdEvent);
        if (is_null($event)) {
            $this->_forward('error', 'error', 'admin',array('errorMessage'=>'L\'évènement n\'existe pas'));
        }
        
        //obtenir tous les events de l'organisme
        $o = new Application_Model_Row_OrganismeRow();
        //$o->findDependentRowset('Evenement')
        $lesEventsRowset = $this->_organisme->findDependentRowset('Application_Model_DbTable_Evenement');
        
        
        //l'organisme en cours doit être un organisme auquel appartient l'utilisateur
        $userOrganismes = $user->getOrganismes();
        
        
        $this->view->event = $event;
        
        $datas = array(
            "titreEvent"        => $event->titreEvent,
            "descEvent"         => $event->descEvent,
            "fileLogo"          => "tesT.jpg", 
            "dateDebutEvent"    => "2013/03/24",
            "heureDebutEvent"   => "12:34",
            "dateFinEvent"      => "2013/03/26",
            "heureFinEvent"     => "15:00",
            "persistenceEvent"  => $event->delaiPersistence,
        );
        $form = new Admin_Form_Evenement();
        $form->populate($datas);
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            //
            //vérification des données
            //
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                //récupération des paramètres
                $titreEvent = $form->getValue('titreEvent');
                $descEvent = $form->getValue('descEvent');
                $fileLogo = $form->getValue('fileLogo');
                $dateDebutEvent = $form->getValue('dateDebutEvent');
                $heureDebutEvent = $form->getValue('heureDebutEvent');
                $dateFinEvent = $form->getValue('dateFinEvent');
                $heureFinEvent = $form->getValue('heureFinEvent');
                $persistenceEvent = $form->getValue('persistenceEvent');
                $numEvent = null; //TODO générer un nom court d'évènement
                
                //
                //controles de données
                //
                $error = false;
                $validatorDate = new Zend_Validate_Date();
                if (!$validatorDate->isValid($dateDebutEvent)) {
                    //date de debut non valide
                    $error = true;
                }
                if (!$validatorDate->isValid($dateFinEvent)) {
                    //date de fin non valide
                    $error = true;
                }

                //TODO : la date/heure de début doit être antérieure à la date/heure de fin (si la date de fin est renseignée
                //TODO : le titre est obligatoire
                //TODO : voir si on empêche ou pas les doublons de titre
                $validatorRecordExists = new Zend_Validate_Db_RecordExists(
                                array(
                                    'table' => 'evenement',
                                    'field' => 'titreEvent'
                                )
                );
                
                if ($validatorRecordExists->isValid($titreEvent)) {
                    // L'évènement avec $titreEvent existe déjà
                    $form->addErrors(array('eventAlreadyExists' => 'Un évènement avec ce titre existe déjà.'));
                    $error = true;
                }
                
                //
                //persistence en DB
                //
                $eventTable = new Application_Model_DbTable_Evenement();
                $eventTable->setEvent($this->_organisme->idOrga, $titreEvent, $numEvent, $descEvent, $fileLogo, $dateDebutEvent, $dateFinEvent, $persistenceEvent);
                
                
            }
        }
        
    }
    
    public function supprimerAction() {
        
    }
    
    public static function getUserFromAuth() {
        $auth = Zend_Auth::getInstance();
        $utilisateur = null;
        if ($auth->hasIdentity()) {
            $idUser = $auth->getIdentity()->idUser;
            $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
            $utilisateur = $tableUtilisateur->find($idUser)->current();
        }
        return $utilisateur;
    }

}


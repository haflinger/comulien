<?php

class Admin_EvenementController extends Zend_Controller_Action {

    private $_logger;
    private $_organisme;
    private $_session;

    public function init() {
        $this->_logger = Zend_Registry::get("cml_logger");
        $this->_logger->err('init du controlleur Admin_Evenement');
        
        //récupération de la session
        $this->_session = new Zend_Session_Namespace('admin');
        
        //récupération de l'organisme
        $this->_organisme = Zend_Registry::get("organismeAdmin");
    }

    public function indexAction() {
        // action body
        $this->view->test = 'bienvenue dans le controlleur Evenement du module admin';
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
        $Evenement = new Application_Model_DbTable_Evenement();
        $this->view->events = $Evenement->fetchAll();
    }

    public function modifierAction() {
        
    }
    
    public function supprimerAction() {
        
    }
    
}


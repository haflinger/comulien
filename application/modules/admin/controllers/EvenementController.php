<?php

class Admin_EvenementController extends Zend_Controller_Action
{

    private $_logger;
    
    public function init()
    {
        $this->_logger = Zend_Registry::get("cml_logger");
        $this->_logger->err('init du controlleur Admin_Evenement');
    }

    public function indexAction()
    {
        // action body
        $this->view->test = 'bienvenue dans le controlleur Evenement du module admin';
    }
    
    public function ajouterAction()
    {
        $form = new Application_Form_Evenement();
        $this->view->form = $form;
        $this->view->test = "TODO : ici on pourra ajouter un evènement";
        
    }
    
    public function listerAction()
    {
        $Evenement = new Application_Model_DbTable_Evenement();
        $this->view->events=$Evenement->fetchAll();
    }

   
}


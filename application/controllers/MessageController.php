<?php

/**
 * Description of MessageController
 * 
 * @author Fred H
 * 
 * 
 *
 *
 */

class MessageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $Message = new Application_Model_DbTable_Message();
        $this->view->entries = $Message->fetchAll();
    }

    public function listerTousAction()
    {
        $defaultNamespace = new Zend_Session_Namespace('bulle');
        if (isset($defaultNamespace->checkedInEvent)){
            //si la session contient un evenement
            $evenement = $defaultNamespace->checkedInEvent;
            $Message = new Application_Model_DbTable_Message();
            $this->view->messages = $Message->fetchAll('idEvent='.$evenement->idEvent);
        }else{
            //TODO : pas d'évènement en session : que faire ? redirection sur le checkin ?
        }
        
    }

    public function listerOrganisateurAction()
    {
        // action body
    }

    public function reponsesAction()
    {
        // action body
    }

    public function approuverAction()
    {
        // action body
    }

    public function envoyerAction()
    {
        // action body
    }

    public function repondreAction()
    {
        // action body
    }

    public function modererAction()
    {
        // action body
    }

    public function gererEvenementAction()
    {
        // action body
    }

    public function creerEvenementAction()
    {
        // action body
    }


}


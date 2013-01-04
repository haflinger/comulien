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
    private $_evenement;
    
    public function init()
    {
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        //session active ?
        if (isset($bulleNamespace->checkedInEvent)) {
            $this->_evenement = $bulleNamespace->checkedInEvent;
            //La ligne qui suit est indispensable pour que les tables liées à la table évènement 
            //  soient mémorisées dans la session
            //  http://gustavostraube.wordpress.com/2010/05/11/zend-framework-cannot-save-a-row-unless-it-is-connected/
            $this->_evenement->setTable(new Application_Model_DbTable_Evenement());
        }
        else
        {
            $this->_evenement = null;
            //$this->view->evenement = $bulleNamespace->checkedInEvent;
        }
    }

    public function indexAction()
    {
        $Message = new Application_Model_DbTable_Message();
        $this->view->entries = $Message->fetchAll();
    }

    public function listerTousAction()
    {
        //création d'une instance du formulaire
        $form = new Application_Form_EcrireMessage();
        //on passe le formulaire à la vue
        $this->view->formEcrireMessage = $form;
        
        if (!is_null($this->_evenement)){
            //si la session contient un evenement
            $Message = new Application_Model_DbTable_Message();
            $messagesTous = $Message->messagesTous($this->_evenement);
            $this->view->messages = $messagesTous;//$Message->fetchAll('idEvent='.$this->_evenement->idEvent);
        }else{
            //TODO : pas d'évènement en session : que faire ? redirection sur le checkin ?
        }
        
    }

    public function listerOrganisateurAction()
    {
        if (!is_null($this->_evenement)){
            //si la session contient un evenement
            $Message = new Application_Model_DbTable_Message();
            $messagesOrganisateurs = $Message->messagesOrganisateur($this->_evenement);
            $this->view->messages = $messagesOrganisateurs;
            
        }else{
            //TODO : pas d'évènement en session : que faire ? redirection sur le checkin ?
        }
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
        /**
         * Envoyer un message et vérifier le message à persister 
         */
        // on vérifie qu'il y ai des données postées et on les valide
        if ($this->_request->isPost()) {
            $form = new Application_Form_EcrireMessage();
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                //on récupère les données du formulaire
                //faire du contrôle de saisie :
                // $profil doit faire partie des profils de l'utilisateur dans cet organisme
                // $message ne doit pas être vide, de taille limitée ...
                $message = $form->getValue('message');
                $profil = $form->getValue('choixProfil');
                if ($profil=='0') {
                    $profil = null;
                }
                $this->view->message=$message;
                $this->view->profil=$profil;
                //TODO : choisir la navigation à donner après l'envoi du message
                $auth = Zend_Auth::getInstance ();
                if ($auth->hasIdentity ()) {
                    $idUser = $auth->getIdentity ()->idUser;
                }else{
                    //TODO
                    $this->view->message='erreur d\'identité';
                    return ;
                }
                $table = new Application_Model_DbTable_Message();
                //$dateheure = DateTime::format('y-m-d H:i:s u');
                $dateheure = Date('y-m-d H:i:s u');
                $data = array(
                    'idUser_emettre' => $idUser,//todo : récupérer l'id de l'utilisateur avec zend_auth
                    'idTypeMsg' => 0,//inutilisé pour le moment mais obligatoire
                    'idEvent' => $this->_evenement->idEvent,
                    'lblMessage' => $message,
                    'idProfil' => $profil,
                    'dateEmissionMsg' => $dateheure,
                    'dateActiviteMsg' => $dateheure,
                    );
                $table->insert($data);
                
                
            }
            else{
                //todo
                $this->view->message='formulaire invalide';
            }
        }else{
            //todo
             
        }
        
    }

    public function repondreAction()
    {
        // action body
    }

    public function modererAction()
    {
        // action body
    }

    
    
}


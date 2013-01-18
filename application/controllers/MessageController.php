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
    const PRIVILEGE_ACTION = 'envoyer';
    const RESOURCE_CONTROLLER = 'message';
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
        
        if (!is_null($this->_evenement)){
            //si la session contient un evenement
            
            //Récupération du droit de modération de l'utilisateur dans l'évènement
            $auth = Zend_Auth::getInstance ();
            $moderateur = false;
            $UtilisateurActif = null;
            if ($auth->hasIdentity ()) {
                $idUser = $auth->getIdentity ()->idUser;
                $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
                $UtilisateurActif = $tableUtilisateur->find($idUser)->current();
                
                $moderateur = $UtilisateurActif->estModerateur($this->_evenement);
            }
            
            //passe à la vue le droit de l'utilisateur à modérer
            $this->view->moderateur = $moderateur;
            
            //vérification du droit d'écrire un message
            
            //Détermination du rôle de l'utilisateur dans l'organisme
            if (!is_null($UtilisateurActif)) {
                $role = $UtilisateurActif->getRole($this->_evenement->idOrga);
            }else{
                $role = 'visiteur';
            }

            //définition 
            $resourceController  = self::RESOURCE_CONTROLLER;// 'message';
            $privilegeAction     = self::PRIVILEGE_ACTION;//'envoyer';
            $ACL = Zend_Registry::get('Zend_Acl');
            if($ACL->isAllowed($role, $resourceController, $privilegeAction))
            {
                $formEcrire = new Application_Form_EcrireMessage();
                $this->view->formEcrireMessage = $formEcrire;
            }
            else
            {
                $this->view->formEcrireMessage = null;
                   $this->view->formEcrireMessage = null;
            }


            //récupération des messages
            $tableMessage = new Application_Model_DbTable_Message();
            $messagesTous = $tableMessage->messagesTous($this->_evenement,$moderateur);
            $this->view->messages = $messagesTous;
            
            
        }else{
            //TODO : pas d'évènement en session : que faire ? redirection sur le checkin ?
        }
        
    }
    
    public function listerReponse($id){
        //récupération des réponses au message
            $tableMessage = new Application_Model_DbTable_Message();
            $reponses = $tableMessage->getReponses($id);
            $this->view->messages = $reponses;
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
        //récupération des paramètres
        $idMessage = $this->getRequest()->getParam('message');
        $appreciation = $this->getRequest()->getParam('appreciation');
        
        //vérification du paramètre appreciation
        if ($appreciation=='1') {
            $note = 1;            
        }elseif ($appreciation=='-1') {
            $note = -1;
        }elseif ($appreciation=='0') {
            $note = 0;
        }else{
            throw new HttpInvalidParamException("l'appreciation doit être '-1' ou '0' ou '1'");
        }
        
        //vérification du paramètre message
        $table = new Application_Model_DbTable_Message();
        $message = $table->getMessage($idMessage);
        
        //récupération de l'utilisateur en session
        $utilisateur = $this->getUserFromAuth();
        
        //approuver le message
        $table->apprecierMessage($message,$utilisateur,$note);
        $this->view->info = 'Appréciation déposée ! (message : '.$message->idMessage.', appreciation : '.$note.')';
                  
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
//            $this->view->message = $formData;
//            return;
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
                
                //insertion du message
                $table = new Application_Model_DbTable_Message();
                
                $dateheure = Date('y-m-d H:i:s u');//TODO : utiliser zend_date pour générer une date
                $data = array(
                    'idUser_emettre' => $idUser,//todo : récupérer l'id de l'utilisateur avec zend_auth
                    'idTypeMsg' => 0,//inutilisé pour le moment mais obligatoire
                    'idEvent' => $this->_evenement->idEvent,
                    'lblMessage' => $message,
                    'idProfil' => $profil,
                    'dateEmissionMsg' => $dateheure,
                    'dateActiviteMsg' => $dateheure,
                    );
                
                $table->posterMessage($data);
                
                //message posté ! on redirige sur les messages 
                
                $this->_helper->redirector ( 'lister-tous', 'message' , null );
                
                
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
        $logger = Zend_Registry::get("cml_logger");
        //récupération de l'utilisateur connecté
        $auth = Zend_Auth::getInstance ();
        
        if (!$auth->hasIdentity()) {
            //pas d'utlisateur authentifié
            $logger->info('Tentative de modération sans authentification');
            $this->view->retour = 'Oops ! Qui êtes vous pour vouloir faire ca ?';
            return;
        }
        
        //l'utilisateur en session doit avoir le droit de modération au sein de l'organisme 
        //récupération de l'id de l'utilisateur en session
        $idUser = $auth->getIdentity ()->idUser;
        //récupération de l'objet UtilisateurRow
        $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
        $UtilisateurActif = $tableUtilisateur->find($idUser)->current();
        //Récupération d'un booleen sur le UtilisateurRow pour savoir si l'utilisateur est modérateur
        $moderateur = $UtilisateurActif->estModerateur($this->_evenement);
        if (!$moderateur) {
            //l'utilisateur n'est pas modérateur
            $logger->info('L\'utilisateur \''.$idUser.'\' a tenté de modérer un message' );
            $this->view->retour = 'Je ne pense pas que vous aillez le droit de faire cela dans cet évènement !';
            return;
        }
        $form = new Application_Form_Moderer();
        //récupération de l'id du message à modérer
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                //on récupère les données du formulaire
                $idMessage = $formData['hiddenIdMessage'];
            }
        }
        //$idMessage = $formData->getValue('hiddenIdMessage');
//        $idMessage = $this->getRequest()->getParam('message');
        if (is_null($idMessage)) {
            $logger->info('Demande de modération sans id de message à modérer');
            $this->view->retour = 'Il n\'y a aucun message à modérer';
            return;
        }
        
        
        $table = new Application_Model_DbTable_Message();
        //récupération du message dans la base
        try {
            $rowMessage = $table->getMessage($idMessage);
        } catch (Exception $exc) {
            $logger->info('Tentative de modération du message '.$idMessage.' sans authentification');
            Zend_Debug::dump($exc, $label = 'Impossible de récupérer le message', $echo = true);
            return;
        }

        //préparation du statut d'actif/inactif (1/0) du message
        //(bascule 1 / 0)
        $actif = ($rowMessage->estActifMsg=='1') ? '0' : '1';

        //modération du message
        $table->modererMessage($idMessage,$idUser,$actif);
        
        $chActif = ($actif=='1') ? 'ré-' : 'dés';
        $this->view->retour = 'Le message #'.$idMessage.' a été '.$chActif .'activé !';
        
    }

    /**
     * Récupère l'utilisateur en session ou null si pas d'utilisateur connecté
     * @return UtilisateurRow l'utilisateur en session
     */
    public static function getUserFromAuth(){
        $auth = Zend_Auth::getInstance ();
        $utilisateur = null;
        if ($auth->hasIdentity ()) {
            $idUser = $auth->getIdentity ()->idUser;
            $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
            $utilisateur = $tableUtilisateur->find($idUser)->current();
        }
        return $utilisateur;
        
    }
    
}


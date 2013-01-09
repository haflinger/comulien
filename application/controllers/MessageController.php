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
            
            //Récupération du droit de modération de l'utilisateur dans l'évènement
            $auth = Zend_Auth::getInstance ();
            $moderateur = false;
            if ($auth->hasIdentity ()) {
                $idUser = $auth->getIdentity ()->idUser;
                $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
                $UtilisateurActif = $tableUtilisateur->find($idUser)->current();
                
                $moderateur = $UtilisateurActif->estModerateur($this->_evenement);
            }
            
            $showAll = false;
            if($moderateur){
                $showAll = true;
            }
            
            $messagesTous = $Message->messagesTous($this->_evenement,$showAll);
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
        
        //récupération de l'id du message à modérer
        $idMessage = $this->getRequest()->getParam('message');
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


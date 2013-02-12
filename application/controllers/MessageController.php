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
    private $_evenement = null;
    const PRIVILEGE_ACTION = 'envoyer';
    const RESOURCE_CONTROLLER = 'message';
    
    const NB_MESSAGES_PAR_PAGE = 5;
    
    public function init()
    {
        if (Zend_Registry::isRegistered('checkedInEvent')) {
            $this->_evenement = Zend_Registry::get('checkedInEvent');
        }
        
        $contextSwitch = $this->_helper->contextSwitch();
        $contextSwitch->addActionContext('reponses', 'json')
                      ->addActionContext('approuver', 'json')
                      ->addActionContext('lister-tous', 'json')
                      ->addActionContext('lister-organisateur', 'json')
                      ->initContext();
    }

    
    public function indexAction()
    {
        $Message = new Application_Model_DbTable_Message();
        $this->view->entries = $Message->fetchAll();
    }
    
    public function listerOrganisateurAction()
    {
        //si la session contient un evenement
        $tableMessage = new Application_Model_DbTable_Message();
        $messagesOrganisateurs = $tableMessage->messagesOrganisateur($this->_evenement->idEvent);
        
        $context = $this->_helper->getHelper('contextSwitch')->getCurrentContext();
        if ($context=='json') {
            $messagesOrganisateurs = $messagesOrganisateurs->toArray();
        }
        $this->view->messages = $messagesOrganisateurs;
    }

    public function listerTousAction()
    {
        $context = $this->_helper->getHelper('contextSwitch')->getCurrentContext();
        //
        //Récupération du droit de modération de l'utilisateur dans l'évènement
        //
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
        
        //
        //vérification du droit d'écrire un message
        //

        //Détermination du rôle de l'utilisateur dans l'organisme
        if (!is_null($UtilisateurActif)) {
            $role = $UtilisateurActif->getRole($this->_evenement->idOrga);
        }else{
            $role = 'visiteur';
        }
       
        //
        // prise en charge du formulaire
        //
        if ($context!='json') { //le formulaire n'est pas envoyé pour du json
            $formEcrire = new Application_Form_EcrireMessage();
            $formEcrire->generer();
            $this->view->formEcrireMessage = $formEcrire;
//            $resourceController  = self::RESOURCE_CONTROLLER;// 'message';
//            $privilegeAction     = self::PRIVILEGE_ACTION;//'envoyer';
//            $ACL = Zend_Registry::get('Zend_Acl');
//            if($ACL->isAllowed($role, $resourceController, $privilegeAction))
//            {
//                $formEcrire = new Application_Form_EcrireMessage();
//                $formEcrire->generer();
//                $this->view->formEcrireMessage = $formEcrire;
//            }
//            else
//            {
//                $this->view->formEcrireMessage = null;            
//            }
        }else{
            //ici nous traitons le json
        }
        
        //
        // traitement de la pagination
        //
//        $numPage = $this->getRequest()->getParam('numpage'); //obsolethe lorsque la pagination par date sera fonctionnelle
//        $validator = new Zend_Validate_Int();
//        if ($validator->isValid($numPage) ) {
//            //TODO : gérer les bornes (peut être faut t'il utiliser zend_validate_between
//            $page = $numPage;
//        }else{
//            $page = 0;
//        }
        $fromDate = $this->getRequest()->getParam('fromdate',  null );
        //TODO : les dates en paramètres vont transiter sous forme de timestamps
        if (!is_null($fromDate)) {
            $fromDate = new Zend_Date($fromDate, Zend_Date::TIMESTAMP);
        }  
        
        //récupération des messages
        $tableMessage = new Application_Model_DbTable_Message();
        $messagesTous = $tableMessage->messagesTous($this->_evenement->idEvent,$moderateur,$page,self::NB_MESSAGES_PAR_PAGE, $fromDate);
        //ATTENTION la ligne suivante bug si on a pas assez de résultats
        if ($messagesTous->count() > 0) {
            $stringDateProchaine = $messagesTous->getRow( $messagesTous->count()-1)->dateActiviteMsg;
            $zendDateProchaine = new Zend_Date( $stringDateProchaine ,'yyyy-MM-dd HH:mm:ss S' );
            $dateProchaine = $zendDateProchaine->getTimestamp();
        } else {
            $dateProchaine = null;
        }
        
        //message/lister-tous/fromdate/xxxxxxx/
        
        if ($context=='json') {
            $messagesTous = $messagesTous->toArray();
        }
        $this->view->dateProchaine = $dateProchaine; //on retourne un timestamp
        $this->view->messages = $messagesTous;
        
    }
    

    public function reponsesAction()
    {

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
        
        $fromDate = $this->getRequest()->getParam('fromdate',  null );
        //TODO : les dates en paramètres vont transiter sous forme de timestamps
        if (!is_null($fromDate)) {
            //$estDate = Zend_Date::isDate($fromDate,Zend_Date::TIMESTAMP);
            $fromDate = new Zend_Date($fromDate, Zend_Date::TIMESTAMP);
        }
        
        $idMessage = $this->getRequest()->getParam('message');
        $lesReponses = null;
        if (!is_null($idMessage)) {
            $idEvent = $this->_evenement->idEvent;
            //récupération des messages
            $tableMessage = new Application_Model_DbTable_Message();
            $lesReponses = $tableMessage->reponsesMessage($idMessage, $idEvent, $moderateur,self::NB_MESSAGES_PAR_PAGE,$fromDate);
        }
        if ($lesReponses->count() > 0) {
            $stringDateProchaine = $lesReponses->getRow( $lesReponses->count()-1)->dateActiviteMsg;
            $zendDateProchaine = new Zend_Date( $stringDateProchaine ,'yyyy-MM-dd HH:mm:ss S' );
            $dateProchaine = $zendDateProchaine->getTimestamp();
        } else {
            $dateProchaine = null;
        }
        //selon le context, retourne un array (pour le json) ou un rowset pour la vue html
        $context = $this->_helper->getHelper('contextSwitch')->getCurrentContext();
        if ($context=='json') {
            $lesReponses = $lesReponses->toArray();
        }
        $this->view->reponses = $lesReponses;
        $this->view->dateProchaine = $dateProchaine; //on retourne un timestamp
        
    }

    public function approuverAction()
    {
        $context = $this->_helper->getHelper('contextSwitch')->getCurrentContext();
        
        if ($this->_request->isPost()) {
            $postData = $this->_request->getPost();
            $idMessage = $postData['message'];
            $appreciation = $postData['appreciation']; 
        } else {
            //TODO : en production, ne plus utiliser le GET pour apprécier un message
            $idMessage = $this->getRequest()->getParam('message');
            $appreciation = $this->getRequest()->getParam('appreciation');
        }
        
        //récupération de l'utilisateur en session
        $utilisateur = $this->getUserFromAuth();
        $this->view->noteGlobale = null;
        if (is_null($idMessage) || is_null($appreciation)) {
            $this->view->info = 'paramètres invalides';
            if ($context!='json') {
                return;
            }else{
                $this->view->user = $utilisateur;
                //redirection uniquement si pas de json
                $this->_helper->redirector ( 'lister-tous', 'message' , null );
            }
        }
        
        //vérification du paramètre message
        $table = new Application_Model_DbTable_Message();
        $message = $table->getMessage($idMessage);
        
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
        
        
        //approuver le message
        $table->apprecierMessage($message,$utilisateur,$note);
        
        //récupérer la note du message
        $lesAppreciations = $message->getAppreciers();
        $noteGlobale = 0;
        $lesAppreciations->count();
        foreach ($lesAppreciations as $app) {
            $noteGlobale += $app->evaluation ;
        }
        $this->view->noteGlobale = $noteGlobale;
        
        $this->view->info = 'Appréciation déposée ! (message : '.$message->idMessage.', appreciation : '.$note.')';
//        $bulleNamespace = new Zend_Session_Namespace('bulle');
//        $this->view->retour = $bulleNamespace->retour;
        
        if ($context=='json') {
            //en json, on va retourner la nouvelle note pour le message
//            $arrayUser = array(
//                'idUser'=>$utilisateur->idUser,
//                'loginUser'=>$utilisateur->loginUser,
//                'emailUser'=>$utilisateur->emailUser,
//                'dateInscriptionUser'=>$utilisateur->dateInscriptionUser,
//                'nomUser'=>$utilisateur->nomUser,
//                'prenomUser'=>$utilisateur->prenomUser,
//                'nbMsgUser'=>$utilisateur->nbMsgUser,
//                'nbApprouverUser'=>$utilisateur->nbApprouverUser,
//                'estActifUser'=>$utilisateur->estActifUser
//                );
//            $this->view->user = $arrayUser;
        }else{
            $this->view->user = $utilisateur;
            //redirection uniquement si pas de json
            $this->_helper->redirector ( 'lister-tous', 'message' , null );
        }
        
        
    }

    public function envoyerAction()
    {
        /**
         * Envoyer un message et vérifier le message à persister 
         */
        // on vérifie qu'il y ai des données postées et on les valide
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            
            //$this->view->message = var_dump($formData);
            
            //récupération du message parent (si possible)
            $idMessageParent = $formData['IdMessageParent'];
            
            $form = new Application_Form_EcrireMessage();
            $form->generer($idMessageParent);
            if ($form->isValid($formData)) {
                //on récupère les données du formulaire
                //faire du contrôle de saisie :
                // $message ne doit pas être vide, de taille limitée ...
//                $message = $form->getValue('message'.$idMessageParent);
//                $profil = $form->getValue('choixProfil'.$idMessageParent);
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

                $table->posterMessage($idUser,0,$this->_evenement->idEvent,$message,$profil,$idMessageParent);
                
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


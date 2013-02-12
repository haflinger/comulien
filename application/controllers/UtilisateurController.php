<?php

/**
 * Description of UtilisateurController
 * 
 * @author Fred H
 *
 *
 *
 */

class UtilisateurController extends Zend_Controller_Action
{   
        
    private $_evenement;
    
    public function init()
    {
        if (Zend_Registry::isRegistered('checkedInEvent')) {
            $this->_evenement = Zend_Registry::get('checkedInEvent');
        }
            
    }
    
    public function preDispatch() {

    }
    
    public function testAction()
    {
        $auth = Zend_Auth::getInstance ();
        $utilisateur = null;
        if ($auth->hasIdentity ()) {
            $idUser = $auth->getIdentity ()->idUser;
            $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
            $utilisateur = $tableUtilisateur->find($idUser)->current();
        }
        
        $this->view->test = $utilisateur->getDistinction($this->_evenement->idOrga);
    }
    
    public function indexAction()
    {
        //$Utilisateur = new Application_Model_DbTable_Utilisateur();
        //$this->view->entries = $Utilisateur->fetchAll();
        $utilisateur = $this->getUserFromAuth();

        $this->view->moderateur = $utilisateur->estModerateur($this->_evenement);
        $this->view->role = $utilisateur->getRole($this->_evenement->idOrga);
        $this->view->utilisateur = $utilisateur;
        $this->view->evenement = $this->_evenement;
        
    }

    public function profilpriveAction()
    {
        //ATTENTION cette action permet de voir le profil complet de l'utilisateur

        $auth = Zend_Auth::getInstance ();
        if ($auth->hasIdentity ()) {
            //on prend l'id de l'utilisateur en session
            $idUser = $auth->getIdentity ()->idUser;
            $Utilisateur = new Application_Model_DbTable_Utilisateur();
            $this->view->user = $Utilisateur->find($idUser)->current();
            $helperUrl = new Zend_View_Helper_Url ( );
            $this->view->profilPublicLink = $helperUrl->url ( array ('action' => 'profilpublic', 'controller' => 'utilisateur','id'=>$idUser ),'default',true );
            $this->view->lienModifier = $helperUrl->url ( array ('action' => 'modifier', 'controller' => 'utilisateur'),'default',true );
        }else{
            //pas de session, on redirige sur le login
            $this->_helper->redirector ( 'authentifier', 'utilisateur');
        }
        
    }

    public function profilpublicAction()
    {
        //ATTENTION cette action permet de voir le profil complet de l'utilisateur
        // dont l'id est passé en paramètres
        //TODO : revoir le comportement lors de l'utilisation réelle ...
        // pour ne rendre que les informations non sensibles
        $id = $this->getRequest()->getParam('id');// utilisateur/profil/id/1
        $validator = new Zend_Validate_Digits();

        if ($id!=null ) { 
            //un id en paramètres : on l'utilise
            if ( $validator->isValid($id) && $id>0 ){
                $Utilisateur = new Application_Model_DbTable_Utilisateur();
                $user = $Utilisateur->find($id)->current();
                $this->view->user = $user;
            }
            else
            {
                //TODO : gérer les cas d'erreur : redirection sur une page d'erreur ? ou autre... ???
                $this->view->user = null;
            }
        } else { //sinon : on redirige sur monProfil
            $this->_helper->redirector ( 'profilprive');
        }
    }

    public function inscrireAction()
    {
        $formInscription =  new Application_Form_InscrireUtilisateur();
        $this->view->formInscription = $formInscription;
        //si le formulaire est posté
        if ($this->getRequest()->isPost()) {
        //on récupère les données postées
            $formData = $this->getRequest()->getPost();
            //si les données postées sont valides 
//            $formInscription->setOptions($formData);
//            $formInscription->render();
            //$this->view->$errorsMessages = $formInscription->getMessages();
            if ($formInscription->isValid($formData)) {
                //on récupère les données qui nous intéressent
                $login = $formInscription->getValue('login');
                $email = $formInscription->getValue('email');
                $password = $formInscription->getValue('password');
                $confirmPassword = $formInscription->getValue('confirmPassword');
                $nom = $formInscription->getValue('nom');
                $prenom = $formInscription->getValue('prenom');
                
                //vérifications
                
                $validatorIdentical = new Zend_Validate_Identical($password);
                $validatorRecordExists = new Zend_Validate_Db_RecordExists(
                    array(
                        'table' => 'utilisateur',
                        'field' => 'loginUser'
                    )
                );
                $error = false;
                if ($validatorRecordExists->isValid($login) ) {
                    // Le login existe déjà
                    $formInscription->addErrors(array('loginAlreadyExists'=>'Cet identifiant est déjà utilisé.'));
                    $error=true;
                }
                if (!$validatorIdentical->isValid($confirmPassword)) {
                    $formInscription->addErrors(array('passwordMispelled'=>'Les mots de passe sont différents'));
                    $error=true;
                }
                if (!$error) {
                    
                    //insertion du nouvel utilisateur
                    //instance du model 'Utilisateur'
                    $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
                    //utilisation de la function addUser du modele
                    $tableUtilisateur->addUser($login, $email, $password, $nom, $prenom);
                    
                    //redirection après complétion du formulaire
                    $this->_forward('authentifier','utilisateur');
                }
            }else{
                

            }
        }
    
    }

    public function modifierAction()
    {
        $formInscription =  new Application_Form_InscrireUtilisateur();
        $formInscription->getElement('submit')->setLabel('Modifier');
        $formInscription->setAction('modifier');
        $this->view->formInscription = null; //valeur par défaut. Sera rempli avec les besoins
        
        //si le formulaire est posté
        if ($this->getRequest()->isPost()) {
        //on récupère les données postées
            $formData = $this->getRequest()->getPost();
            //si les données postées sont valides 
            if ($formInscription->isValid($formData)) {
                //on récupère les données qui nous intéressent
                $login = $formInscription->getValue('login');
                $email = $formInscription->getValue('email');
                $password = $formInscription->getValue('password');
                $confirmPassword = $formInscription->getValue('confirmPassword');
                $nom = $formInscription->getValue('nom');
                $prenom = $formInscription->getValue('prenom');
                
                //vérifications
                
                $validatorIdentical = new Zend_Validate_Identical($password);
//                $validatorRecordExists = new Zend_Validate_Db_RecordExists(
//                    array(
//                        'table' => 'utilisateur',
//                        'field' => 'loginUser'
//                    )
//                );
                $error = false;
//                if ($validatorRecordExists->isValid($login) ) {
//                    // Le login existe déjà
//                    $formInscription->addErrors(array('loginAlreadyExists'=>'Cet identifiant est déjà utilisé.'));
//                    $error=true;
//                }
                if (!$validatorIdentical->isValid($confirmPassword)) {
                    $formInscription->addErrors(array('passwordMispelled'=>'Les mots de passe sont différents'));
                    $error=true;
                }
                if (!$error) {
                    //insertion du nouvel utilisateur
                    //instance du model 'Utilisateur'
                    $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
                    //utilisation de la function addUser du modele
                    $tableUtilisateur->updateUser($login, $email, $password, $nom, $prenom);
                    //TODO : renvoyer sur une page de confirmation ?
                    $this->_helper->redirector ( 'profilprive');
                }
                
            }
        }  
        else //la requête n'est pas post
        {
            //on affiche le formulaire d'inscription prérempli
            $user = self::getUserFromAuth();
            if (is_null($user)) {
                //si il n'y a pas d'utilisateur en session
                $this->_helper->redirector ( 'authentifier');
            }
            
            $formData = array(
                'login'=>$user->loginUser,
                'email'=>$user->emailUser,
                'password'=>'',
                'nom'=>$user->nomUser,
                'prenom'=>$user->prenomUser
                    );
            $formInscription->populate($formData);
            $this->view->formInscription = $formInscription;
            
        }
            
    }
    
    public function authentifierAction()
    {
        //création d'une instance du formulaire
        $form = new Application_Form_Login();
        //on passe le formulaire à la vue
        $this->view->formLogin = $form;
        
        // on vérifie qu'il y ai des données postées et on les valide
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                //on récupère les données du formulaire
                $login = $form->getValue('login');
                $password = $form->getValue('password');
                //on créé le connecteur d'authentification avec le connecteur de la BDD
                $authAdapter = new Zend_Auth_Adapter_DbTable ( Zend_Db_Table::getDefaultAdapter () );
                //on informe l'adapteur d'authentification de la table et des champs à utiliser pour l'identification
                $authAdapter->setTableName ( 'utilisateur' ) //table des utilisateurs
                        ->setIdentityColumn ( 'loginUser' ) //champ des identifiants
                        ->setCredentialColumn ( 'pswUser' ) //champ des mdp
                        ->setCredentialTreatment ( 'MD5(?)' ) //'MD5(?)' pour le hashage MD5
                        ->setIdentity ( $login ) //le login à vérifier
                        ->setCredential ( $password ); //le psw à vérifier
                //lancement de la tentative d'authentification
                $authAuthenticate = $authAdapter->authenticate ();
                //vérification de l'authentification
                if ($authAuthenticate->isValid ()) {
                    //ok : on met en session les infos de l'utilisateur
                    // - récupération de l'espace de stockage de l'application
                    $storage = Zend_Auth::getInstance ()->getStorage ();
                    // - écriture dans le stockage des infos de l'utilisateur (sans le mot de passe)
                    $storage->write ( $authAdapter->getResultRowObject ( null, 'password' ) );
                    // - et finalement on redirige l'utilisateur sur la page principale de l'application
                    
                    //TODO : rediriger sur la page qui précède l'authentification
                    //$bulleNamespace = new Zend_Session_Namespace('bulle');
                    //$redirection = $bulleNamespace->retour;
                    if (Zend_Registry::isRegistered('ModuleReferer')){
                        $module = Zend_Registry::get('ModuleReferer');
                        $controller = Zend_Registry::get('ControllerReferer');
                        $action = Zend_Registry::get('ActionReferer');
                        $this->_helper->redirector ( $action,$controller,$module);
                    } else {
                        //pas de page d'origine sur laquelle retourner...
                        $this->_helper->redirector ( 'index', 'utilisateur' );
                    }
                    //$this->_helper->redirector ( 'accueil', 'evenement' );
                } else {
                    //NOK : on affiche une erreur
                    $form->addError ( 'Il n\'existe pas d\'utilisateur avec ce mot de passe' );
                }
            }
        }
    }
    
    public function deconnecterAction()
    {
        //suppression des informations de l'utilisateur
        Zend_Auth::getInstance ()->clearIdentity ();
        //redirection vers le controlleur index, action index
        $this->_helper->redirector ( 'accueil', 'evenement' );
    }
    
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


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
    
    public function preDispatch() {
//        //vérification si l'utilisateur est connecté 
//        // afin de lui permettre de se déconnecter
//        //TODO : faire un peu plus de description sur ce point
//        if (Zend_Auth::getInstance ()->hasIdentity ()) { 
//            if ('deconnecter' != $this->getRequest ()->getActionName ()) {
//                $this->_helper->redirector ( 'index', 'utilisateur' );
//            }
//        } else {
//            if ('deconnecter' == $this->getRequest ()->getActionName ()) {
//                $this->_helper->redirector ( 'authentifier' );
//            }
//        }
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
        
        //$this->view->test = $user->getProfils($this->_evenement)->toArray();
        $this->view->test = $utilisateur->getRole($this->_evenement->idOrga);
    }
    public function indexAction()
    {
        $Utilisateur = new Application_Model_DbTable_Utilisateur();
        $this->view->entries = $Utilisateur->fetchAll();
    }

    public function profilpriveAction()
    {
        //ATTENTION cette action permet de voir le profil complet de l'utilisateur
        // dont l'id est passé en paramètres
        //TODO : revoir le comportement lors de l'utilisation réelle

        $auth = Zend_Auth::getInstance ();
        if ($auth->hasIdentity ()) {
            //on prend l'id de l'utilisateur en session
            $idUser = $auth->getIdentity ()->idUser;
            $Utilisateur = new Application_Model_DbTable_Utilisateur();
            $this->view->user = $Utilisateur->find($idUser)->current();
            $helperUrl = new Zend_View_Helper_Url ( );
            $this->view->profilPublicLink = $helperUrl->url ( array ('action' => 'profilpublic', 'controller' => 'utilisateur','id'=>$idUser ),'default',true );
            $this->view->lienModifier = $helperUrl->url ( array ('action' => 'profilpublic', 'controller' => 'utilisateur','id'=>$idUser ),'default',true );
        }else{
            //pas de session, on redirige sur le login
            $this->_helper->redirector ( 'authentifier', 'utilisateur');
        }
        
    }

    public function profilpublicAction()
    {
        //ATTENTION cette action permet de voir le profil complet de l'utilisateur
        // dont l'id est passé en paramètres
        //TODO : revoir le comportement lors de l'utilisation réelle
        $id = $this->getRequest()->getParam('id');// utilisateur/profil/id/1
        if ($id!=null) { 
            //un id en paramètres : on l'utilise
            $Utilisateur = new Application_Model_DbTable_Utilisateur();
            $this->view->user = $Utilisateur->find($id)->current();
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
            if ($formInscription->isValid($formData)) {
                //on récupère les données qui nous intéressent
                $login = $formInscription->getValue('login');
                $email = $formInscription->getValue('email');
                $password = $formInscription->getValue('password');
                $nom = $formInscription->getValue('nom');
                $prenom = $formInscription->getValue('prenom');
                //insertion du nouvel utilisateur
                //instance du model 'Utilisateur'
                $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
                //utilisation de la function addUser du modele
                $tableUtilisateur->addUser($login, $email, $password, $nom, $prenom);

                //éventuellle redirection
                $this->_forward('authentifier','utilisateur');
            }
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
                    $this->_helper->redirector ( 'modifier', 'utilisateur' );
                } else {
                    //NOK : on affiche une erreur
                    $form->addError ( 'Il n\'existe pas d\'utilisateur avec ce mot de passe' );
                }
            }
        }
    }

    public function modifierAction()
    {
        //ATTENTION cette action permet de voir le profil complet de l'utilisateur
        // dont l'id est passé en paramètres
        //TODO : revoir le comportement lors de l'utilisation réelle
//        $id = $this->getRequest()->getParam('id');// utilisateur/profil/id/1
//        if ($id!=null) { 
//            //un id en paramètres : on l'utilise
//            $Utilisateur = new Application_Model_DbTable_Utilisateur();
//            $this->view->user = $Utilisateur->find($id)->current();
//        } else { //sinon : on redirige sur monProfil
//           // $this->_helper->redirector ( 'profilprive');
//        }
        
        //////
        $formInscription =  new Application_Form_InscrireUtilisateur();
        $user = self::getUserFromAuth();
        if (is_null($user)) {
            //TODO faire une redirection
            return;
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
    
//
//        //ATTENTION cette action permet de voir le profil complet de l'utilisateur
//       // dont l'id est passé en paramètres
//       //TODO : revoir le comportement lors de l'utilisation réelle
//
//       $auth = Zend_Auth::getInstance ();
//       if ($auth->hasIdentity ()) {
//           //on prend l'id de l'utilisateur en session
//           $idUser = $auth->getIdentity ()->idUser;
//           $Utilisateur = new Application_Model_DbTable_Utilisateur();
//           $this->view->user = $Utilisateur->find($idUser)->current();
//           $helperUrl = new Zend_View_Helper_Url ( );
//           $this->view->profilPublicLink = $helperUrl->url ( array ('action' => 'profilpublic', 'controller' => 'utilisateur','id'=>$idUser ),'default',true );
//       }else{
//           //pas de session, on redirige sur le login
//           $this->_helper->redirector ( 'authentifier', 'utilisateur' );
//       }
   
    
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


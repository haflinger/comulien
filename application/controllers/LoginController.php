<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author alexsolex
 */
class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
    public function preDispatch() {
        //vérification si l'utilisateur est connecté 
        // afin de lui permettre de se déconnecter
        //TODO : faire un peu plus de description sur ce point
        if (Zend_Auth::getInstance ()->hasIdentity ()) { 
            if ('logout' != $this->getRequest ()->getActionName ()) {
                $this->_helper->redirector ( 'index', 'evenement' );
            }
        } else {
            if ('logout' == $this->getRequest ()->getActionName ()) {
                $this->_helper->redirector ( 'login' );
            }
        }
    }
    
    public function indexAction()
    {
        //redirection de l'action index vers l'action login
        //TODO : voir si c'est judicieux et utile...
        $this->_forward('login');

    }
    
    public function loginAction()
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
                        ->setCredentialTreatment ( '?' ) //'MD5(?)' pour le hashage MD5
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
                    $this->_helper->redirector ( 'index', 'index' );
                } else {
                    //NOK : on affiche une erreur
                    $form->addError ( 'Il n\'existe pas d\'utilisateur avec ce mot de passe' );
                }
            }
        }
    }
    
    public function logoutAction()
    {
        //suppression des informations de l'utilisateur
        Zend_Auth::getInstance ()->clearIdentity ();
        //redirection vers le controlleur index, action index
        $this->_helper->redirector ( 'index', 'index' );
    }
    
    

}


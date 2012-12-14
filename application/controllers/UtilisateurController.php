<?php

/**
 * Description of UtilisateurController
 *
 * @author Fred H
 */
class UtilisateurController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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
              //$this->_helper->url(array('controller'=>'utilisateur', 'action'=>'profilpublic', 'id'=>$idUser),'default',true);
            //$helperUrl->url ( array ('action' => 'profilpublic', 'controller' => 'utilisateur','id'=>$idUser ),'default',true );
        }else{
            //pas de session, on redirige sur le login
            $this->_helper->redirector ( 'login', 'login' );
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
   

}


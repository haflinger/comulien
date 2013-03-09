<?php

class Admin_IndexController extends Zend_Controller_Action
{

    private $_logger;
    
    public function init()
    {
        $this->_logger = Zend_Registry::get("cml_logger");
        $this->_logger->err('Arrivée dans le module admin...');
    }

    public function indexAction()
    {
        // action body
//        $form = new Application_Form_Example();
//        $this->view->form = $form;
        $auth = Zend_Auth::getInstance ();
        if ($auth->hasIdentity ()) {
            //on prend l'id de l'utilisateur en session
            $idUser = $auth->getIdentity ()->idUser;
            $Utilisateur = new Application_Model_DbTable_Utilisateur();
            $this->view->user = $Utilisateur->find($idUser)->current();
//            $helperUrl = new Zend_View_Helper_Url ( );
//            $this->view->profilPublicLink = $helperUrl->url ( array ('action' => 'profilpublic', 'controller' => 'utilisateur','id'=>$idUser ),'default',true );
//            $this->view->lienModifier = $helperUrl->url ( array ('action' => 'modifier', 'controller' => 'utilisateur'),'default',true );
            
            //Récupération des distinctions de l'utilisateur (ce qui configurera ses droits d'accès sur le module admin
            $table = new Application_Model_DbTable_Distinguer();
            $results = $table->getAllDistinctionForUser($idUser);
            $this->view->results = $results;
            
        }else{
            //pas de session, on redirige sur le login
            $this->_helper->redirector (array('module'=>'admin','controller'=>'utilisateur','action'=>'authentifier'));
            // $this->_helper->redirector('test');
        }
    }

    public function testAction()
    {
        $this->view->test = "ceci est un message de test dans le controlleur index du module admin";
    }

}


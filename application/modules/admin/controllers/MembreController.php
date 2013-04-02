<?php

class Admin_MembreController extends Zend_Controller_Action {

    private $_logger;
    private $_organisme;
    private $_session;
    private $_user;

    public function init() {
        $this->_logger = Zend_Registry::get("cml_logger");
        $this->_logger->err('init du controlleur Admin_Evenement');
        
        //récupération de la session
        $this->_session = new Zend_Session_Namespace('admin');
        
        //récupération de l'organisme
        $this->_organisme = Zend_Registry::get("organismeAdmin");
        
        //récupération de l'utilisateur
        $this->_user = $this->getUserFromAuth();
        $this->view->user = $this->_user;
    }

    public function affilierAction() {
        
    }
    
    public function revoquerAction() {
        
    }
    
    public function inviterAction() {
        
    }
}
?>

<?php

class Admin_MembreController extends Zend_Controller_Action {

    private $_logger;
    private $_organisme;
    private $_session;

    public function init() {
        $this->_logger = Zend_Registry::get("cml_logger");
        $this->_logger->err('init du controlleur Admin_Evenement');
        
        //récupération de la session
        $this->_session = new Zend_Session_Namespace('admin');
        
        //récupération de l'organisme
        $this->_organisme = Zend_Registry::get("organismeAdmin");
    }

    public function affilierAction() {
        
    }
    
    public function revoquerAction() {
        
    }
    
    public function inviterAction() {
        
    }
}
?>

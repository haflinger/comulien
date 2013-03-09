<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_OrganismeController extends Zend_Controller_Action
{   
        
    private $_organisme;
    private $_session;
    
    public function init()
    {
        if (Zend_Registry::isRegistered('organismeAdmin')) {
            $this->_organisme = Zend_Registry::get('organismeAdmin');
        }
        
        $this->_session = new Zend_Session_Namespace('admin');
        
    }
    
    public function preDispatch() {

    }
    
    public function creerAction() {
        
    }
    
    public function editerAction() {
        
    }
    
    public function listerAction() {
        $form = new Admin_Form_ChoixOrganisme();
        
        //récupérer un array de tous les organismes dans lesquels est affilié l'utilisateur
        $user = $this->getUserFromAuth();
        $userOrganismes = $user->getOrganismes();
        $arrayOrganismes = array();
        foreach ($userOrganismes as $orga) {
            $arrayOrganismes[$orga->idOrga]=$orga->nomOrga;
        }
        $form->chargeOrganisme($arrayOrganismes);
        
        
        $this->view->formChoixOrganisme = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->populate($formData);
            if ($form->isValid($formData)) {
                $idOrganisme = $form->getValue('ChoixOrganisme');
                
                $tableOrganisme = new Application_Model_DbTable_Organisme();
                $Organisme = $tableOrganisme->getOrganismeParID($idOrganisme);
                //$Organisme = $arrayOrga[$idOrganisme];
                $this->setOrganisme($Organisme);
                $this->view->idOrganisme = $idOrganisme;
                
            }
            
        }
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

     private function setOrganisme($Organisme)
    {
        //evènement dans la session
        $this->_session->organisme = $Organisme;
        //dans le registre
        Zend_Registry::set('organismeAdmin',$Organisme);
        //dans la donnée membre privé
        $this->_organisme = $Organisme;
        
    }
}
?>

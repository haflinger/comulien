<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_OrganismeController extends Zend_Controller_Action
{   
        
    private $_organisme;
    
    public function init()
    {
        $adminNameSpace = new Zend_Session_Namespace('admin');
        $this->_organisme = $adminNameSpace->organisme;
    }
    
    public function preDispatch() {

    }
    
    public function creerAction() {
        
    }
    
    public function editerAction() {
        
    }
    
    public function listerAction() {
        $form = new Application_Form_ChoixOrganisme();
        $form->chargeOrganisme(array("test"=>"ceci est un test","essai"=>"ceci est un essai"));
        
        $this->view->formChoixOrganisme = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            //if ($form->isValid($formData)) {
                $idOrganisme = $form->getValue('ChoixOrganisme');
                $this->view->idOrganisme = $idOrganisme;
            //}
            
        }
    }
}
?>

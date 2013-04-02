<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_OrganismeController extends Zend_Controller_Action
{   
        
    private $_organisme = null;
    private $_user = null;
    private $_session;
    
    public function init()
    {
        if (Zend_Registry::isRegistered('organismeAdmin')) {
            $this->_organisme = Zend_Registry::get('organismeAdmin');
        }
        
        $this->_session = new Zend_Session_Namespace('admin');

        $this->view->organisme = $this->_organisme;
        
        $this->_user = $this->getUserFromAuth();
        $this->view->user = $this->_user;
        
    }
    
    public function preDispatch() {
        
    }
    
    public function indexAction() {
        if (!is_null($this->_organisme)) {
            $this->view->organisme = $this->_organisme;
        }
    }
    
    public function creerAction() {
        
    }
    
    public function editerAction() {
        
        $form = new Admin_Form_Organisme();
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            
            if ($form->isValid($formData)) {
                $nomOrga = $form->getValue("nomOrga");
                $descOrga = $form->getValue("descOrga");
                $logoOrga = $form->getValue("logoOrga");
                //gestion de l'upload
                $adapter = new Zend_File_Transfer_Adapter_Http();
//
//                $adapter->setDestination('C:\comulien');
                $upload = new Zend_File_Transfer();
                
                
                //$upload->setDestination('C:\comulien');
                // Retourne toutes les informations connues sur le fichier
                $files = $upload->getFileInfo();
                //$upload->addFilter('Rename', APPLICATION_PATH.'/../public/images/organisme/'.'test'.'.jpg');
                $upload->addFilter('Rename', APPLICATION_PATH.'/test.png');
                
                foreach ($files as $file => $info) {
                    // Fichier uploadé ?
                    if (!$upload->isUploaded($file)) {
                        print "Pourquoi n'avez-vous pas uploadé ce fichier ?";
                        continue;
                    }

                    // Les validateurs sont-ils OK ?
//                    if (!$upload->isValid($file)) {
//                        print "Désolé mais $file ne correspond à ce que nous attendons";
//                        continue;
//                    }
                }

                
                if (!$upload->receive()) {
                    $messages = $adapter->getMessages();
                    echo implode("\n", $messages);
                }
                
                $this->_organisme = new Application_Model_DbTable_Organisme();
                //TODO : persister les modifications
                //$this->_organisme->update (array("nomOrga"=>$nomOrga,"descOrga"=>$descOrga,"logoOrga"=>$logoOrga) , array("idOrga=?",$this->_organisme->idOrga));
            }
        } 
        else {
            $params = array(
                "nomOrga"=>$this->_organisme->nomOrga,
                "descOrga"=>$this->_organisme->descOrga,
                "logoOrga"=>$this->_organisme->logoOrga
                    );
            $form->populate($params);
        }
        
        $this->view->formEditionOrganisme = $form;
        
    }
    
    public function listerAction() {
        
        $form = new Admin_Form_ChoixOrganisme();
        
        //récupére l'utilisateur
        $user = $this->getUserFromAuth();
        //récupère les organismes dans lesquels l'utilisateur a un rôle
        $userOrganismes = $user->getOrganismes();
        //génère un tableau pour alimenter le formulaire
        $arrayOrganismes = array();
        foreach ($userOrganismes as $orga) {
            $arrayOrganismes[$orga->idOrga]=$orga->nomOrga;
        }
        //charge le formulaire avec le tableau de valeurs, et positionne le select sur l'id fourni
        $idOrga = null;
        if (!empty($this->_organisme)) {
            $idOrga = $this->_organisme->idOrga;
        }
        $form->chargeOrganisme($arrayOrganismes,$idOrga);
        
        
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
                $message = 'Vous administrez désormais l\'organisme \''.$Organisme->nomOrga.'\'';
                $this->_forward('index');
                $this->view->idOrganisme = $message;//$idOrganisme;
                
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

<?php

class Application_Form_EcrireMessage extends Twitter_Form//Zend_Form
{
    const PRIVILEGE_ACTION = 'envoyer';
    const RESOURCE_CONTROLLER = 'message';
  
    private $_idMessageParent = null;
//    private $_nomSubmitButton;
//    
//    public function __construct($idMessageParent=null) {
//        parent::__construct();
//        //todo tester le idmessageparent
//        $this->setIdMessageParent($idMessageParent);
//        
//        
//    }
//
//    private function setIdMessageParent($idMessage){
//        $this->_idMessageParent = $idMessage;
//    }
//    
    public function generer($idMessageParent=null)
    {
        
        //récupération de l'idOrga de l'évènement en session
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        //session active ?
        if (isset($bulleNamespace->checkedInEvent)) {
            $event = $bulleNamespace->checkedInEvent;
            $IDorga = $event->idOrga;
        }
        else
        {
            return ;

        }
//        
        // récupération de l'utilisateur
        $auth = Zend_Auth::getInstance ();
        if ($auth->hasIdentity ()) {
            $idUser = $auth->getIdentity ()->idUser;
//            $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
//            $user = $tableUtilisateur->find($idUser)->current();
        }else{
            //TODO
            //return ;

        }

        // La méthode HTTP d'envoi du formulaire
        $this->setMethod('post');

        // l'action utilisée pour l'envoi du message
        $this->setAction(self::PRIVILEGE_ACTION);
        //
        
        //un champ masqué pour l'id du message parent
        $hiddenIdMessageParent = new Zend_Form_Element_Hidden('IdMessageParent');
        if (!is_null($idMessageParent)) {
            $hiddenIdMessageParent->setValue($idMessageParent);
        }else{
            $hiddenIdMessageParent->setValue(null);
        }
       
        
            
        
        //zone de texte pour la saisie du message
        //TODO : modifié textarea + son nom
        //$message = new Zend_Form_Element_Text('message'.$idMessageParent);
        $message = new Zend_Form_Element_Text('message');
        $message->setAllowEmpty(false);
        $message->setAttrib('placeholder','Votre message');
        $message->setRequired(true);
        //$message->setAttrib('cols', 35)
               // ->setAttrib('rows', 4);
        //$message->addValidator('StringLength',array(0,10)); //todo à vérifier
        
        //
        // combobox de sélection du profil à utiliser
        // 
        //récupération des distinctions de l'utilisateur dans l'organisme
        $distinguer = new Application_Model_DbTable_Distinguer();
        $lesProfils = $distinguer->getProfils($idUser, $IDorga);

        //création d'un élément de formulaire de sélection du profil
        //$profil = new Zend_Form_Element_Select('choixProfil'.$idMessageParent,array(
        $profil = new Zend_Form_Element_Select('choixProfil',array(
            'MultiOptions' => $lesProfils
            ) );
        
        //$submit = new Zend_Form_Element_Submit ( 'envoyer'.$idMessageParent );
        $submit = new Zend_Form_Element_Submit ( 'envoyer' );
        $submit->setLabel('Envoyer')
                ->setAttrib('style',"display:none");
        
        $elements = array ($hiddenIdMessageParent, $message, $profil, $submit );
        $this->addElements ( $elements );
         $this->setDecorators(array(
            array('ViewScript',array('viewScript' => 'forms/ecrireMessage.phtml'))
        ));
       
        
    }


    
    
}


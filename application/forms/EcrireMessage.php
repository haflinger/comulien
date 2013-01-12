<?php

class Application_Form_EcrireMessage extends Zend_Form
{
    const PRIVILEGE_ACTION = 'envoyer';
    const RESOURCE_CONTROLLER = 'message';
  
    public function init()
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
            return ;
        }
//        
//        //Détermination du rôle de l'utilisateur dans l'organisme
//        if (!is_null($user)) {
//            $role = $user->getRole($IDorga);
//        }else{
//            $role = 'visiteur';
//        }
//        
//        //définition 
//        $resourceController  = self::RESOURCE_CONTROLLER;// 'message';
//        $privilegeAction = self::PRIVILEGE_ACTION;//'envoyer';
//        $ACL = Zend_Registry::get('Zend_Acl');
//        if(!$ACL->isAllowed($role, $resourceController, $privilegeAction))
//        {
//            $this->addError($role);
//            return ;
//        }
        
        // La méthode HTTP d'envoi du formulaire
        $this->setMethod('post');

        // l'action utilisée pour l'envoi du message
        $this->setAction(self::PRIVILEGE_ACTION);
        //
        //zone de texte pour la saisie du message
        //
        $message = new Zend_Form_Element_Textarea('message');
        $message->setAllowEmpty(false);
        $message->setAttrib('placeholder','Votre message');
        $message->setRequired(true);
        
        //$message->addValidator('StringLength',array(0,10)); //todo à vérifier
        $message->setAttrib('cols', 35)
                ->setAttrib('rows', 4);
        
        //
        // combobox de sélection du profil à utiliser
        // 
        //récupération des distinctions de l'utilisateur dans l'organisme
        $distinguer = new Application_Model_DbTable_Distinguer();
        $lesProfils = $distinguer->getProfils($idUser, $IDorga);

        //création d'un élément de formulaire de sélection du profil
        $profil = new Zend_Form_Element_Select('choixProfil',array(
            'label'        => 'Profil à utiliser :',
            'MultiOptions' => $lesProfils,
            'class'=>'maclasse'
            ) );
        
        //
        // essai du captcha
        // ( http://framework.zend.com/manual/1.12/fr/zend.captcha.adapters.html )
        // Un captcha
//        $this->addElement('captcha', 'captcha', array(
//            'label'      => 'Veuillez saisir la lettre:',
//            'required'   => true,
//            'captcha'    => array(
//                'captcha' => 'Figlet',
//                'wordLen' => 1,
//                'timeout' => 300
//            )
//        ));


        $submit = new Zend_Form_Element_Submit ( 'submit' );
        $submit->setAttrib ( 'id', 'submitbutton' )
                ->setLabel ( 'Envoyer' );

        $elements = array ($message, $profil, $submit );
        $this->addElements ( $elements );

    }


}


<?php

class Application_Form_EcrireMessage extends Zend_Form
{

    public function init()
    {
        // La méthode HTTP d'envoi du formulaire
        $this->setMethod('post');
        
        // l'action utilisée pour l'envoi du message
        $this->setAction('envoyer');
        //
        //zone de texte pour la saisie du message
        //
        $message = new Zend_Form_Element_Textarea('message');
        $message->setAllowEmpty(false);
        $message->setLabel('Votre message');
        $message->setRequired(true);
        //$message->addValidator('StringLength',array(0,10)); //todo à vérifier
        $message->setAttrib('cols', 35)
                ->setAttrib('rows', 4);
        
        //
        // combobox de sélection du profil à utiliser
        // 
        //TODO : besoin de récupérer les différents profils de l'utilisateur dans l'organisme
        //récupération de l'idUser depuis l'authentification
        $auth = Zend_Auth::getInstance ();
        if ($auth->hasIdentity ()) {
            $idUser = $auth->getIdentity ()->idUser;
        }else{
            //TODO
            //$this->view->message='erreur d\'identité';
            return ;
        }
        //récupération de l'idOrga de l'évènement en session
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        //session active ?
        if (isset($bulleNamespace->checkedInEvent)) {
            $event = $bulleNamespace->checkedInEvent;
            $IDorga = $event->idOrga;
        }
        else
        {
            //$this->view->message='erreur d\'identité';
            return ;
            //$this->view->evenement = $bulleNamespace->checkedInEvent;
        }
        //récupération des distinction de l'utilisateur dans l'organisme
        $distinguer = new Application_Model_DbTable_Distinguer();
        $lesProfils = $distinguer->getProfils($idUser, $IDorga);
        //$lesProfils = array ('0'=>'Utilisateur','1'=>'Organisateur','2'=>'Corporate','3'=>'Annonceur'); // todo 
        $profil = new Zend_Form_Element_Select('choixProfil',array(
            'label'        => 'Profil à utiliser :',
            'MultiOptions' => $lesProfils,
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


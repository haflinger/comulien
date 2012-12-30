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
        $lesProfils = array ('0'=>'','1'=>'Organisateur','2'=>'Corporate','3'=>'Annonceur'); // todo 
        $profil = new Zend_Form_Element_Select('choixProfil',array(
            'label'        => 'Profil à utiliser :',
            'MultiOptions' => $lesProfils,
            ) );
        


        $submit = new Zend_Form_Element_Submit ( 'submit' );
        $submit->setAttrib ( 'id', 'submitbutton' )
                ->setLabel ( 'Envoyer' );

        $elements = array ($message, $profil, $submit );
        $this->addElements ( $elements );

    }


}


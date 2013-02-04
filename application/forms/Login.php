<?php

class Application_Form_Login extends Twitter_Form//Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */ 
        $this->setName ( 'connect_user' );
        /*si on veut spécifier l'action du controller pour le formulaire :
         * $this->setAction('valider');
         * positionne la validation du formulaire vers l'action 'login' du controleur
         */
        $this->setAction('authentifier');
        
        $login = new Application_Form_EText ('login' );
        $login->setAttrib('placeholder','Identifiant');
        $password = new Zend_Form_Element_Password ( 'password' );
        $password->setAttrib('placeholder','Mot de passe')
                ->addFilter ( 'StripTags' )
                ->addFilter ( 'StringTrim' )
                ->setRequired ( true );

        $submit = new Zend_Form_Element_Submit ( 'submit' );
        $submit->setAttrib ( 'id', 'submitbutton' )->setLabel ( 'Connexion' );

        $elements = array ($login, $password, $submit );
        $this->addElements ( $elements );
        
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'forms/connexion.phtml'))
        ));

    }


}


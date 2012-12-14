<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */ 
        $this->setName ( 'connect_user' );
        /*si on veut spécifier l'action du controller pour le formulaire :
         * $this->setAction('valider');
         * positionne la validation du formulaire vers l'action 'login' du controleur
         */
        $this->setAction('login');
        
        $login = new Application_Form_EText ( 'form_user_add_name', 'login' );
        $password = new Zend_Form_Element_Password ( 'password' );
        $password->setLabel ( 'form_user_add_password' )
                ->addFilter ( 'StripTags' )
                ->addFilter ( 'StringTrim' )
                ->setRequired ( true );

        $submit = new Zend_Form_Element_Submit ( 'submit' );
        $submit->setAttrib ( 'id', 'submitbutton' )->setLabel ( 'form_user_add_submit' );

        $elements = array ($login, $password, $submit );
        $this->addElements ( $elements );
    }


}


<?php

class Application_Form_InscrireUtilisateur extends Twitter_Form//Zend_Form
{
 
    public function init()
    {
        $this->setMethod('post') //method du formulaire
                ->setName('register') //nom du formulaire
                ->setAction('inscrire');
        $this->addElement("text", "login", array(
            "label" => "Login",
            "description" => "Le login sera utilisé pour l'identification et dans vos messages"
        ));
        
        $this->addElement("text", "email", array(
//            "validators" => array(
//                'emailAddress',
//                
//            ),
            "label" => "Email",
            "description" => "L'adresse mail sera vérifiée",
            "required" => true
        ));
        
        $this->addElement("password", "password", array(
            "label" => "Password",
            "description" => "Please enter a nice password.",
            "required" => true,
        ));

        $this->addElement("password", "oldpassword", array(
                     "label" => "Old Password",
                     "value" => "******",
                     "description" => "This is your old password. Keep going.",
                     "attribs" => array(
                             "disabled" => true
                     )
             ));
        
        $this->addElement("text", "nom", array(
            "label" => "Nom"
        ));
        
        $this->addElement("text", "prenom", array(
            "label" => "Prenom"
        ));
        
        $this->addElement("submit", "submit", array("label" => "Register"));
        $this->addElement("reset", "reset", array("label" => "Reset"));
        $this->addElement("button", "custom", array(
                "class" => "success",
                "label" => "Custom classes, too!"
        ));
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'forms/inscrireUtilisateur.phtml'))
        ));
        
        
//$elm_login = new Zend_Form_Element_Text('login');//nom de l'input
//        $elm_login ->setLabel('Login')//label de l'input login
//                ->setRequired(true)//vérifie que le login n'est pas vide
//                ->addFilter('StripTags');//Enlève les caractères HTML
//
//        $elm_email = new Zend_Form_Element_Text('email');
//        $elm_email ->setLabel('Email')
//                ->setRequired(true)//vérifie que email n'est pas vide
//                ->addFilter('StripTags')//Enlève les caractères HTML
//                ->addValidator('EmailAddress');//vérifie la syntaxe du mail
//        
//        $elm_pwd = new Zend_Form_Element_Password('password');
//        $elm_pwd->setLabel('Mot de passe')
//                ->setRequired(true);
//
//        $elm_pwdConfirm = new Zend_Form_Element_Password('passwordConfirm');
//        $elm_pwdConfirm->setLabel('Mot de passe')
//                ->setRequired(true);
//
//        $elm_nom = new Zend_Form_Element_Text('nom');//nom de l'input
//        $elm_nom ->setLabel('Nom')//label de l'input login
//                ->setRequired(false)//vérifie que le login n'est pas vide
//                ->addFilter('StripTags');//Enlève les caractères HTML
//        
//        $elm_prenom = new Zend_Form_Element_Text('prenom');//nom de l'input
//        $elm_prenom ->setLabel('Prenom')//label de l'input login
//                ->setRequired(false)//vérifie que le login n'est pas vide
//                ->addFilter('StripTags');//Enlève les caractères HTML
//        
//        $elm_submit = new Zend_Form_Element_Submit('submit');
//        $elm_submit ->setLabel('Connexion')
//                ->setIgnore(true);
// 
//        //
//        // essai du captcha
//        // ( http://framework.zend.com/manual/1.12/fr/zend.captcha.adapters.html )
//        // Un captcha
////        $this->addElement('captcha', 'captcha', array(
////            'label'      => 'Veuillez saisir la lettre:',
////            'required'   => true,
////            'captcha'    => array(
////                'captcha' => 'Figlet',
////                'wordLen' => 5,
////                'timeout' => 300
////            )
////        ));	
//        
//		//on ajoute les différents input à la construction du formulaire
//        $this->addElements(array($elm_login, $elm_email, $elm_pwd, $elm_pwdConfirm, $elm_nom, $elm_prenom, $elm_submit));
        
        

    }

}
?>
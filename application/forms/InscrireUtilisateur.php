<?php

class Application_Form_InscrireUtilisateur extends Zend_Form//Twitter_Form//Zend_Form
{
 
    public function init()
    {
        $this->setMethod('post') //method du formulaire
                ->setName('register') //nom du formulaire
                ->setAction('inscrire');
        
        //le login
        $this->addElement("text", "login", array(
            'validators' => array(
//                'db_NoRecordExists'=>array(
//                    'table' => 'utilisateur',
//                    'field' => 'loginuser'
//                    )
            ),
            "label" => "Identifiant",
            "description" => "Le login sera utilisé pour l'identification et dans vos messages",
            "required" => true,
        ));
        
        //l'email
        $this->addElement("text", "email", array(
            "validators" => array(
                'emailAddress',
            ),
            "label" => "Email",
            "description" => "L'adresse mail sera vérifiée",
            "required" => true
        ));
        
        //le mot de passe
        $this->addElement("password", "password", array(
            "validators" => array(
                array('stringLength',false,array('min'=>6,'max'=>15))
            ),
            "label" => "Mot de passe",
            "description" => "Veuillez saisir un mot de passe compris entre 6 et 15 caractères.",
            "required" => true,
        ));
        
        //la vérification du mot de passe
        $this->addElement("password", "confirmPassword", array(
            "validators" => array(
                array('stringLength',false,array('min'=>6,'max'=>15))
            ),
            "label" => "Confirmation du mot de passe",
            "description" => "Pour être valide les mots de passes doivent être identiques.",
            "required" => true,
//            "attribs" => array(
//                    "disabled" => true
//            )
        ));
        
        //le nom
        $this->addElement("text", "nom", array(
            "label" => "Nom"
        ));
        
        //le prénom
        $this->addElement("text", "prenom", array(
            "label" => "Prenom"
        ));
        
        //bouton de validation
        $this->addElement("submit", "submit", array("label" => "Register"));
        
        //bouton de réinitialisation
        $this->addElement("reset", "reset", array("label" => "Réinitialiser"));
        
        //bouton custom (test)
        $this->addElement("button", "custom", array(
                "class" => "success",
                "label" => "Custom classes, too!"
        ));

        //utilisation de la vue partielle de formulaire
        $this->setDecorators(array(
            'PrepareElements',
            array('ViewScript', array('viewScript' => 'forms/inscrireUtilisateur.phtml' )),
        ));
        
        
    }
}
?>
<?php

class Application_Form_ChoixOrganisme extends Zend_Form {
    private $_selectOrga;

    public function init() {
       
    }

    public function chargeOrganisme($arrayOrganismes) {
         $this->setMethod('post') //method du formulaire
                ->setName('choixOrganisme') //nom du formulaire
                ->setAction('lister');
        $this->addElement("select", "ChoixOrganisme", 
                array(
                    "label" => "Choisir un organisme",
//                    "multiOptions" => array(
//                            "car" => "What was your first car?",
//                            "city" => "What is your favorite city?"
//                                        )
                    "multiOptions" => $arrayOrganismes
                     )
        );
        
        $this->addElement("submit", "register", array("label" => "Register"));
    }

}


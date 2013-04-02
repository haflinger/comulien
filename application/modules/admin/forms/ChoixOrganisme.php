<?php

class Admin_Form_ChoixOrganisme extends Zend_Form {
    private $_selectOrga;

    public function init() {
       
    }

    public function chargeOrganisme($arrayOrganismes,$idSelectedOrga) {
         
        $this->setMethod('post') //method du formulaire
                ->setName('choixOrganisme'); //nom du formulaire;
        $this->setAction($this->getView()->url(array('controller' => 'organisme', 'action'=>'lister','module'=>'admin') ));
        
        $this->addElement("select", "ChoixOrganisme", 
                array(
                    "label" => "Choisir un organisme",
//                    "multiOptions" => array(
//                            "car" => "What was your first car?",
//                            "city" => "What is your favorite city?"
//                                        )
                    "multiOptions" => $arrayOrganismes,
                    "value" => $idSelectedOrga
                     )
               
        );
        
        $this->addElement("submit", "Changer", array("label" => "Changer"));
    }

}


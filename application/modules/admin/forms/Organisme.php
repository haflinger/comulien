<?php

class Admin_Form_Organisme extends Twitter_Form {

    public function init() {
        // Make this form horizontal
        $this->setAttrib("horizontal", true);
        //TODO :
        //titre de l'organisme
        $this->addElement("text", "nomOrga", array(
            "label" => "Nom de l'organisme",
            "description" => "Nom de l'organisme"
        ));
        //Description de l'organisme
        $this->addElement("text", "descOrga", array(
            "label" => "Description de l'organisme",
            "description" => "Description de l'organisme"
        ));
        //logo
        //TODO : un fileupload ou un textbox pour saisir une url
        $this->addElement("file", "logoOrga", array(
            "label" => "Charger un logo",
            "required" => true
        ));
        
       
        $this->addElement("submit", "btnCreer", array("label" => "Créer"));
        $this->addElement("reset", "btnReset", array("label" => "Réinitialiser"));
        
    }

}

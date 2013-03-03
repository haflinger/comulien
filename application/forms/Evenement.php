<?php

class Application_Form_Evenement extends Twitter_Form {

    public function init() {
        // Make this form horizontal
        $this->setAttrib("horizontal", true);
        //TODO :
        //titre de l'évènement
        $this->addElement("text", "titreEvent", array(
            "label" => "Nom de l'évènement",
            "description" => "Nom de l'évènement"
        ));
        //Description de l'évènement
        $this->addElement("text", "descEvent", array(
            "label" => "Description de l'évènement",
            "description" => "Description de l'évènement"
        ));
        //logo
        //TODO : un fileupload ou un textbox pour saisir une url
        $this->addElement("file", "fileLogo", array(
            "label" => "Please upload a file",
            "required" => true
        ));
        //date de début
        $this->addElement("text", "dateDebutEvent", array(
            "label" => "Date de début de l'évènement",
            "description" => "Date de début de l'évènement"
        ));
        $this->addElement("text", "heureDebutEvent", array(
            "label" => "Heure de début de l'évènement",
            "description" => "Heure de début de l'évènement"
        ));
        //date de fin
        $this->addElement("text", "dateFinEvent", array(
            "label" => "Date de fin de l'évènement",
            "description" => "Date de fin de l'évènement. Laisser vide pour un évènement permanent"
        ));
        $this->addElement("text", "heureFinEvent", array(
            "label" => "Heure de fin de l'évènement",
            "description" => "Heure de fin de l'évènement"
        ));
        //durée de persistence
       $this->addElement("text", "persistenceEvent", array(
            "label" => "Durée en secondes",
            "description" => "Temps en secondes pendant lequel l'évènement restera consultable même après la fin de l'évènement"
        ));
       
        $this->addElement("submit", "btnCreer", array("label" => "Créer"));
        $this->addElement("reset", "btnReset", array("label" => "Réinitialiser"));
        
    }

}

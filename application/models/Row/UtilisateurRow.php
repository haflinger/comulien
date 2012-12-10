<?php

class Application_Model_Row_UtilisateurRow extends Zend_Db_Table_Row_Abstract
{
    
    //getGravatar : récupère si il existe, l'avatar correspondant à l'adresse email sur le service gravatar
    public function getGravatar(){
        $email = $this->emailUser;
        $default = "http://www.comulien.com/avatar.jpg"; //TODO : trouver un avatar par défaut
        $size = 40;
        $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
        return $grav_url;

    }
}


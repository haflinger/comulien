<?php
require_once('model/gare.php');
require_once('model/dbConnect.php');

class GareDAO{
    public function getGares(){
        
    	$connexion = dbConnect::getInstance();
    	
    	$garesSQL = $connexion->ExecuteSelect('SELECT * FROM gare');
        
        foreach($garesSQL as $gareSQL)
        {
            $gares[] = new Gare($gareSQL['IDGARE'], $gareSQL['NOMGARE']);
        }
        
        return $gares;
    }
}
?>
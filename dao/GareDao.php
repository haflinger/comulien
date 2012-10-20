<?php
include_once('../model/gare.php');

class GareDAO{
    public function getGares(){
        $garesSQL = self::$connexion->ExecuteSelect('SELECT * FROM gare');
        
        foreach($garesSQL as $gareSQL)
        {
            $gares[] = new Gare($gareSQL['IDGARE'], $gareSQL['NOMGARE']);
        }
        
        return $gares;
    }
}
?>
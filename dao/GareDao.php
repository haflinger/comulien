<?php

include_once('../model/gare.php');
class GareDAO{
    //public function getGareById($id){
        //$gareSQL = self::$connexion->ExecuteSelect('SELECT * FROM gare WHERE IDGARE=' . $id );
        //....
        //return $gare;
    //}
    
    public function getGares($id){
        $garesSQL = self::$connexion->ExecuteSelect('SELECT * FROM gare');
        $gares = array();
        foreach($garesSQL as $gareSQL)
        {
            $gares[] = new Gare($gareSQL['IDGARE'], $gareSQL['NOMGARE']);
        }
        
        return $gares;
    }
}
?>
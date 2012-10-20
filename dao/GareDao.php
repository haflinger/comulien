<?php
class GareDAO{
    public function getGareById($id){
        $gare = self::$connexion->ExecuteSelect('SELECT * FROM gare WHERE IDGARE=' . $id );
        return $gare;
    }
    
    public function getGares($id){
        $gares = self::$connexion->ExecuteSelect('SELECT * FROM gare');
        return $gares;
    }
}
?>
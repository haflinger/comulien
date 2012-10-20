<?php
include_once('../model/train.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trainDao
 *
 * @author Fred
 */
class trainDao {
    
    public function getTrainById($id){
        $trainSQL = self::$connexion->ExecuteSelect('SELECT * FROM train WHERE IDTRAIN = ' . $id);
        $train = new train($trainSQL['IDTRAIN'], $trainSQL['NOTRAIN']);
        
        return $train;
    }
    
    public function getTrainByName($name){
        $trainSQL = self::$connexion->ExecuteSelect('SELECT * FROM train WHERE NOTRAIN = ' . $name);
        $train = new train($trainSQL['IDTRAIN'], $trainSQL['NOTRAIN']);
        
        return $train;
    }
    
    public function getTrainsPourGare($idGare)
    {
        //todo.......
    }
}

?>

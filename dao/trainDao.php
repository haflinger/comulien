<?php
include_once('../model/train.php');
require_once(MODELEPATH . 'dbConnect.php');
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
        $connexion = dbConnect::getInstance();
        $trainSQL = $connexion->ExecuteSelect('SELECT * FROM train WHERE IDTRAIN = ' . $id);
        $train = new train($trainSQL['IDTRAIN'], $trainSQL['NOTRAIN']);
        
        return $train;
    }
    
    public function getTrainByName($name){
        $connexion = dbConnect::getInstance();
        $trainSQL = $connexion->ExecuteSelectOne('SELECT * FROM train WHERE NOTRAIN = ' . $name);
        $train = new train($trainSQL['IDTRAIN'], $trainSQL['NOTRAIN']);
        return $train;
    }
    
    public function getTrainsPourGare($idGare)
    {
        //todo...
        
    }
    
    public function createTrain($id, $nomTrain){
        $connexion = dbConnect::getInstance();
        $tabData = array();
        $tabData['idtrain'] = $id;
        $tabData['notrain'] = $nomTrain;
        $connexion->ExecuteInsert('INSERT INTO train(NOTRAIN) VALUES (:NOTRAIN )', $tabData);
    }
}

?>

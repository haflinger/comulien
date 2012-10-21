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
    
function getTrainById($id){
        $connexion = dbConnect::getInstance();
        $trainSQL = $connexion->ExecuteSelect('SELECT * FROM train WHERE IDTRAIN = ' . $id);
        $train = new train($trainSQL['IDTRAIN'], $trainSQL['NOTRAIN']);
        
        return $train;
    }
    
function getTrainByName($name){
        $connexion = dbConnect::getInstance();
        $trainSQL = $connexion->ExecuteSelectOne('SELECT * FROM train WHERE NOTRAIN = ' . $name);
        $train = new train($trainSQL['IDTRAIN'], $trainSQL['NOTRAIN']);
        return $train;
    }
    

function createTrain($nomTrain){
        $connexion = dbConnect::getInstance();
        $tabData = array();
        $tabData['notrain'] = $nomTrain;
        var_dump($tabData);
        $connexion->ExecuteInsert('INSERT INTO train(NOTRAIN) VALUES (:NOTRAIN)', $tabData);
    }

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of train
 *
 * @author Fred
 */
class train {
    private $idtrain;
    private $notrain;
    
    public function __construct($idtrain, $notrain) {
        $this->idtrain = $idtrain;
        $this->notrain = $notrain;
    }
    
    public function getIdtrain(){
        return $this->idtrain;
    }
    public function getNotrain(){
        return $this->notrain;
    }
    public function setIdtrain($id){
        $this->idtrain = $id;
    }
    public function setNotrain($num){
        $this->notrain = $num;
    }
}

?>

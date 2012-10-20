<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of message
 *
 * @author Fred
 */
class message {
    private $idmessage;
    private $lblmessage;
    private $datemessage;
    private $parentmessage;
    private $usermessage;
    
    public function __construct($id, $mess, $date, $parent, $user) {
        $this->idmessage = $id;
        $this->lblmessage = $mess;
        $this->datemessage = $date;
        $this->parentmessage = $parent;
        $this->usermessage = $user;
    }
    
    public function getIdmessage(){
        return $this->idmessage;
    }
    
    public function getlblmessage(){
        return $this->lblmessage;
    }
    
    public function getdatemessage(){
        return $this->datemessage;
    }
    
    public function setIdmessage($id){
        $this->idmessage = $id;        
    }
    public function setlblmessage($mess){
        $this->lblmessage = $mess;        
    }
    public function setdatemessage($date){
        $this->datemessage = $date;        
    }
    
    
}

?>

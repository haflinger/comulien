<?php
/**
 * 
 */
class Zend_View_Helper_NotationMessage extends Zend_View_Helper_Abstract {
   
    public function notationMessage($idMessage) {
        $helperUrl = new Zend_View_Helper_Url ( );
        $okLink = $helperUrl->url ( array ('action' => 'approuver', 'controller' => 'message' , 'message' => $idMessage,'appreciation'=>'ok') );
        $nokLink = $helperUrl->url ( array ('action' => 'approuver', 'controller' => 'message' , 'message' => $idMessage,'appreciation'=>'nok') );
        return "Noter ce message : <a href='".$okLink."' alt=''>+</a> | <a href='".$nokLink."' alt=''>-</a>";
    }
    
}
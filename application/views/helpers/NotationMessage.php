<?php
/**
 * 
 */
class Zend_View_Helper_NotationMessage extends Zend_View_Helper_Abstract {
   
    public function notationMessage($idMessage) {
        $helperUrl = new Zend_View_Helper_Url ( );
        $okLink = $helperUrl->url ( array ('action' => 'approuver', 'controller' => 'message' , 'message' => $idMessage,'appreciation'=>'1') );
        $nokLink = $helperUrl->url ( array ('action' => 'approuver', 'controller' => 'message' , 'message' => $idMessage,'appreciation'=>'-1') );
        $resetLink = $helperUrl->url ( array ('action' => 'approuver', 'controller' => 'message' , 'message' => $idMessage,'appreciation'=>'0') );
        return "Noter ce message : <a href='".$okLink."' alt=''>+</a> | <a href='".$resetLink."' alt=''>0</a> | <a href='".$nokLink."' alt=''>-</a>";
    }
    
}
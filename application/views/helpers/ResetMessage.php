<?php
/**
 * 
 */
class Zend_View_Helper_ResetMessage extends Zend_View_Helper_Abstract {
   
    public function resetMessage($idMessage) {
        $helperUrl = new Zend_View_Helper_Url ( );
        $resetLink = $helperUrl->url ( array ('action' => 'approuver', 'controller' => 'message' , 'message' => $idMessage,'appreciation'=>'0') );
        return $resetLink;
        
    }
    
}
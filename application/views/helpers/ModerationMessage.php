<?php
/**
 * 
 */
class Zend_View_Helper_ModerationMessage extends Zend_View_Helper_Abstract {
   
    public function moderationMessage($idMessage) {
        $helperUrl = new Zend_View_Helper_Url ( );
        $modererLink = $helperUrl->url ( array ('action' => 'moderer', 'controller' => 'message' , 'message' => $idMessage) );
        return "<a href='".$modererLink."' alt=''>Moderer</a>";
    }
    
}
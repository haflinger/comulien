<?php

class Zend_View_Helper_UnlikeMessage extends Zend_View_Helper_Abstract {
   
    public function unlikeMessage($idMessage) {
        $helperUrl = new Zend_View_Helper_Url ( );
        $nokLink = $helperUrl->url ( array ('action' => 'approuver', 'controller' => 'message' , 'message' => $idMessage,'appreciation'=>'-1'), 'default',true);
        return $nokLink;
    }
    
}
?>

<?php

class Zend_View_Helper_LikeMessage extends Zend_View_Helper_Abstract {
   
    public function likeMessage($idMessage) {
        $helperUrl = new Zend_View_Helper_Url ( );
        $okLink = $helperUrl->url ( array ('action' => 'approuver', 'controller' => 'message' , 'message' => $idMessage,'appreciation'=>'1') );
        return $okLink;
    }
    
}
?>

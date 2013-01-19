<?php
/**
 * 
 */
class Zend_View_Helper_ModerationMessage extends Zend_View_Helper_Abstract {
   
    public function moderationMessage($idMessage) {
       $helperUrl = new Zend_View_Helper_Url ( );
       $modererLink = $helperUrl->url ( array ('action' => 'moderer', 'controller' => 'message' , 'message' => $idMessage) , 'default',true);
       return $modererLink;
        
       /* $formModerer = new Application_Form_Moderer();
        $formModerer->setIdMessage($idMessage);
        $formModerer->genererForm();
        return $formModerer;*/
    }
    
}
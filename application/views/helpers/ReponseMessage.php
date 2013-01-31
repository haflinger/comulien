<?php
/**
 * 
 */
class Zend_View_Helper_ReponseMessage extends Zend_View_Helper_Abstract {
   
    /**
     * Helper de vue permettant d'insérer un formulaire de réponse au message
     * @param int $idMessage
     * @return \Application_Form_EcrireMessage
     */
    public function reponseMessage($idMessage) {
        
        $formRepondre = new Application_Form_EcrireMessage($idMessage);
        //$formRepondre->($idMessage);
        //$formRepondre->genererForm();
        return $formRepondre;
        
    }
    
}
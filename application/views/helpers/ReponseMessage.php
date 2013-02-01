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
    public function reponseMessage($idMessageParent) {
        
        //$formRepondre = new Application_Form_RepondreMessage();
        $formRepondre = new Application_Form_EcrireMessage();
        $formRepondre->generer($idMessageParent);
        //$formRepondre->genererForm();
        return $formRepondre;
        
    }
    
}
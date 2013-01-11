<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CheckoutLink
 * Permet de générer le lien de checkout
 * @author Fred H
 */
class Zend_View_Helper_CheckoutLink extends Zend_View_Helper_Abstract {
    public function checkoutLink() {    
        $helperUrl = new Zend_View_Helper_Url();
        $comulienNamespace = new Zend_Session_Namespace('bulle');
        if (isset($comulienNamespace->checkedInEvent))
        {
            //$event = $comulienNamespace->checkedInEvent;
            $checkoutLink = $helperUrl->url ( array ('action' => 'checkout', 'controller' => 'evenement' ) );
            return $checkoutLink;
            
        }
    }
}


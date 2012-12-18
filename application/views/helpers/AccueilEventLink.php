<?php
/**
 * Permet de générer le lien de checkout / checkin dans un évènement
 */
class Zend_View_Helper_AccueilEventLink extends Zend_View_Helper_Abstract {
    
    public function accueilEventLink() {
        $helperUrl = new Zend_View_Helper_Url ( );
        $comulienNamespace = new Zend_Session_Namespace('bulle');
        if (isset($comulienNamespace->checkedInEvent))
        {
            $event = $comulienNamespace->checkedInEvent;
            $accueilLink = $helperUrl->url ( array ('action' => 'accueil', 'controller' => 'evenement' ) );
            $checkoutLink = $helperUrl->url ( array ('action' => 'checkout', 'controller' => 'evenement' ) );
            return '<a href="'.$accueilLink.'" alt="Accueil Evenement">'.'Accueil '.$event->titreEvent.'</a> | <a href="'.$checkoutLink.'" alt="checkout">checkout</a>';
        }
        else
        {
            $accueilLink = $helperUrl->url ( array ('action' => 'liste', 'controller' => 'evenement' ) );
            return 'Vous n\'êtes pas dans un évènement <a href="'.$accueilLink.'" alt="Accueil Evenement">Liste des évènements</a>';
        }
        
    }
}
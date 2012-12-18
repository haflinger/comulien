<?php
/**
 * Permet de générer le lien de connexion / déconnexion
 */
class Zend_View_Helper_AccueilEventLink extends Zend_View_Helper_Abstract {
    
    public function accueilEventLink() {
        $helperUrl = new Zend_View_Helper_Url ( );
        $comulienNamespace = new Zend_Session_Namespace('Comulien');
        if (isset($comulienNamespace->checkedInEvent))
        {
            $event = $comulienNamespace->checkedInEvent;
            $accueilLink = $helperUrl->url ( array ('action' => 'index', 'controller' => 'evenement' ) );
            $checkoutLink = $helperUrl->url ( array ('action' => 'checkout', 'controller' => 'evenement' ) );
            return '<a href="'.$accueilLink.'" alt="Accueil Evenement">'.$event->titreEvent.'</a> | <a href="'.$checkoutLink.'" alt="checkout">checkout</a>';
        }
        else
        {
            $accueilLink = $helperUrl->url ( array ('action' => 'index', 'controller' => 'evenement' ) );
            return 'Vous n\'êtes pas dans un évènement <a href="'.$accueilLink.'" alt="Accueil Evenement">Liste des évènements</a>';
        }
        
    }
}
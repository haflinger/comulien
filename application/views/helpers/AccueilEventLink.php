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
            //$event = $comulienNamespace->checkedInEvent;
            $accueilLink = $helperUrl->url ( array ('action' => 'accueil', 'controller' => 'evenement') , 'default',true);
            //$checkoutLink = $helperUrl->url ( array ('action' => 'checkout', 'controller' => 'evenement', 'default',true);
            //return '<a href="'.$accueilLink.'" alt="Accueil Evenement">'.'Accueil '.$event->titreEvent.'</a><a href="'.$checkoutLink.'" alt="checkout">checkout</a>';
            return $accueilLink;
            
       }
        else
        {
           $accueilLink = $helperUrl->url ( array ('action' => 'liste', 'controller' => 'evenement' ), 'default',true);
           //return '<a href="'.$accueilLink.'" alt="Accueil Evenement">Liste des évènements</a>';
           return $accueilLink;
        }
        
    }
}
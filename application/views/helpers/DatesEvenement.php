<?php
/**
 * Permet de générer un texte pour les dates des évènements
 */
class Zend_View_Helper_DatesEvenement extends Zend_View_Helper_Abstract {
    /**
     * TODO
     * @param string $dateDebut
     * @param string $dateFin
     * @param string $delaiPersistence
     * @return string
     * 
     */
    public function datesEvenement($dateDebut,$dateFin,$delaiPersistence) {
        $helperUrl = new Zend_View_Helper_Url ( );
        $comulienNamespace = new Zend_Session_Namespace('bulle');
        return "Du ".$dateDebut." au ".$dateFin." avec ".$delaiPersistence." minutes de persistence";
        if (isset($comulienNamespace->checkedInEvent))
        {
            $event = $comulienNamespace->checkedInEvent;
            $accueilLink = $helperUrl->url ( array ('action' => 'accueil', 'controller' => 'evenement' , null) );
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
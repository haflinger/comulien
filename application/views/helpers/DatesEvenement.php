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
        $chaineDateDebut = new DateTime(trim($dateDebut));
        $chaineDateFin = new DateTime(trim($dateFin));
        $formatDate = 'd/m/Y à H:i:s';
        return "Du ".$chaineDateDebut->format($formatDate)." au ".$chaineDateFin->format($formatDate)." ( +".$delaiPersistence." min. )";
    }
    
}
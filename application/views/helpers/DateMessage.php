<?php
/**
 * Permet de générer un texte pour les dates des évènements
 */
class Zend_View_Helper_DateMessage extends Zend_View_Helper_Abstract {
    
    public function dateMessage($dateMessage){
        //retourne une unité de temps selon la date 
        //'il y a x secondes' si la même minute
        //'il y a x minutes' si la même heure
        //'il y a x heures' si le même jour
        //'le jj/mm/aa' sinon
        //ATTENTION : j'ai galéré pas mal avec les dates parceque j'utilisais la variable $date
        $mdate = new Zend_Date($dateMessage,'yyyy-MM-dd HH:mm:ss S');//, 'y-m-d H:i:s');
        
        $maintenant = zend_date::now();//new Zend_Date(null,'yyyy-MM-dd HH:mm:ss S');
        //return $mdate . ' / ' . $maintenant . ' / ' . $maintenant->sub($mdate)->get();
        //$interval = $mdate->subDate($maintenant)->toValue(zend_date::SECOND_SHORT);
        $diff = $maintenant->sub($mdate)->get();//->toValue();
    
        if ($diff<60) {
            return $diff.' sec';
        }
        $diff = $diff/60;//diff en minutes
        if ($diff<60) {
            return floor($diff).'min';
        }
        $diff = $diff/60;//diff en heures
        if ($diff<24) {
            return floor($diff).' h';
        }
        $diff = $diff/24; //diff en jours
        if ($diff<2 && $diff>1) {
            return 'hier';
        }
        else{
            return floor($diff).' j';
        }
        return $interval;
    }
}
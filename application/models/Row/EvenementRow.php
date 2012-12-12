<?php

/**
 * Description of DistinguerRow
 *
 * @author Fred H
 */
class Application_Model_Row_EvenementRow extends Zend_Db_Table_Row_Abstract
{
    private $orga = null;
  
     /**
     * @return l'organisme qui à créé l'événement
     */
    public function getOrga()
    {
        try {
            if(!$this->orga)
            $this->orga = $this->findParentRow('Application_Model_DbTable_Organisme');
            return $this->orga;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }   
    }


}


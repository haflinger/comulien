<?php

class Application_Model_Row_MessageRow extends Zend_Db_Table_Row_Abstract
{
    private $event = null;
  
     /**
     * @return l'évènement lié au message
     */
    public function getEvent()
    {
        try {
            if(!$this->event)
            $this->event = $this->findParentRow('Application_Model_DbTable_Evenement');
            return $this->event;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }   
    }
}


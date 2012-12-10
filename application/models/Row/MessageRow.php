<?php

class Application_Model_Row_MessageRow extends Zend_Db_Table_Row_Abstract
{
    private $event = null;
    private $type = null;
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
     /**
     * @return le type du message
     */
    public function getType()
    {
        try {
            if(!$this->type)
            $this->type = $this->findParentRow('Application_Model_DbTable_Typemessage');
            return $this->type;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }   
    }
}


<?php

/**
 * Description of ApprecierRow
 *
 * @author Fred H
 */
class Application_Model_Row_ApprecierRow extends Zend_Db_Table_Row_Abstract{
    protected $user = null;
    protected $message = null;
    
    /**
     * @return l'utilisateur de la relation Apprecier
     */
    public function getUser()
    {
        try {
            if(!$this->user)
            $this->user = $this->findParentRow('Application_Model_DbTable_Utilisateur');
            return $this->user;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }   
    }
    
    /**
     * @return le message de la relation apprecier
     */
    public function getMessage()
    {
        try {
            if(!$this->message)
            $this->message = $this->findParentRow('Application_Model_DbTable_Message');
            return $this->message;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }   
    }
   
}

?>

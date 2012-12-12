<?php

/**
 * Description of DistinguerRow
 *
 * @author Fred H
 */
class Application_Model_Row_DistinguerRow extends Zend_Db_Table_Row_Abstract
{
    protected $user = null;
    protected $profil = null;
    protected $organisme = null;
    /**
     * @return l'utilisateur de la relation distinguer
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
     * @return le profil de la relation distinguer
     */
     public function getProfil()
    {
        try {
            if(!$this->profil)
            $this->profil = $this->findParentRow('Application_Model_DbTable_Profil');
            return $this->profil;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }   
    }
    /**
     * @return l'organisme de la relation distinguer
     */
     public function getOrganisme()
    {
        try {
            if(!$this->organisme)
            $this->organisme = $this->findParentRow('Application_Model_DbTable_Organisme');
            return $this->organisme;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }   
    }
}

?>

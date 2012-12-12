<?php

/**
 * Description of DistinguerRow
 *
 * @author Fred H
 */
class Application_Model_Row_OrganismeRow extends Zend_Db_Table_Row_Abstract
{
    protected $utilisateurs = null;
    protected $distinctions = null;
     /**
     * @return les utilisateurs
     */
    public function getUtilisateurs()
    {
        if (!$this->utilisateurs) {
            $this->utilisateurs = $this->findManyToManyRowset(
                'Application_Model_DbTable_Utilisateur',   
                'Application_Model_DbTable_Distinguer'); 
        }
        return $this->utilisateurs;
    }
    /**
     * @return les distinctions (relation ternaire)
     */
    public function getDistinctions()
    {
        if (!$this->distinctions) {
            $this->distinctions = $this->findDependentRowset(
                'Application_Model_DbTable_Distinguer'); 
        }
        return $this->distinctions;
    }
    
}


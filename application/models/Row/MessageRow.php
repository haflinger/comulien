<?php

class Application_Model_Row_MessageRow extends Zend_Db_Table_Row_Abstract
{
    private $event = null;
    private $type = null;
    private $profil = null;
    private $emetteur = null;
    private $moderateur = null;
    private $utilisateurs = null;
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
     /**
     * @return le profil du message
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
     * @return l'emetteur du message
     */
    public function getUserEmettre()
    {
        try {
            if(!$this->emetteur)
            $this->emetteur = $this->findParentRow('Application_Model_DbTable_Utilisateur');
            return $this->emetteur;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }   
    }
    /**
     * @return le moderateur du message
     */
    public function getUserModerer()
    {
        try {
            if(!$this->moderateur)
            $this->moderateur = $this->findParentRow('Application_Model_DbTable_Utilisateur');
            return $this->moderateur;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }   
    }
    
    /**
     * @return retourne les auteurs
     */
    public function getUtilisateurs()
    {
        if (!$this->utilisateurs) {
            $this->utilisateurs = $this->findManyToManyRowset(
                'Application_Model_DbTable_Utilisateur',   // match table
                'Application_Model_DbTable_Apprecier');  // join table
        }
        return $this->utilisateurs;
    }
}

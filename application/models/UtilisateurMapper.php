<?php

class Application_Model_UtilisateurMapper
{
protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Utilisateur');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Utilisateur $utilisateur)
    {
       $data = array(
            'loginUser'   => $utilisateur->getLoginUser(),
            'pswUser' => $utilisateur->getPswUser(),
            'emailUser' => $utilisateur->getEmailUser(),
            'dateInscriptionUser' => $utilisateur->getDateInscriptionUser(),
            'nomUser'   => $utilisateur->getNomUser(),
            'prenomUser' => $utilisateur->getPrenomUser(),
            'nbMsgUser' => $utilisateur->getNbMsgUser(),
            'nbApprouverUser' => $utilisateur->getNbApprouverUser(),
            'estActifUser' => $utilisateur->getEstActifUser()
        );
 
        if (null === ($idUser = $utilisateur->getIdUser())) {
            unset($data['idUser']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('idUser = ?' => $idUser));
        }
    }
 
    public function find($id, Application_Model_Utilisateur $utilisateur)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $utilisateur->setIdUser($row->idUser)
                ->setLoginUser($row->loginUser)
                ->setPswUser($row->pswUser)
                ->setEmailUser($row->emailUser) 
                ->setDateInscriptionUser($row->dateInscriptionUser)
                ->setNomUser($row->nomUser)
                ->setPrenomUser($row->prenomUser)
                ->setNbMsgUser($row->nbMsgUser)
                ->setNbApprouverUser($row->nbApprouverUser)
                ->setEstActifUser($row->estActifUser);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Utilisateur();
            $entry->setIdUser($row->idUser)
                ->setLoginUser($row->loginUser)
                ->setPswUser($row->pswUser)
                ->setEmailUser($row->emailUser)  
                ->setDateInscriptionUser($row->dateInscriptionUser)
                ->setNomUser($row->nomUser)
                ->setPrenomUser($row->prenomUser)
                ->setNbMsgUser($row->nbMsgUser)
                ->setNbApprouverUser($row->nbApprouverUser)
                ->setEstActifUser($row->estActifUser);
            $entries[] = $entry;
        }
        return $entries;
    }


}


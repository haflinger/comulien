<?php

class Application_Model_ProfilMapper
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
            $this->setDbTable('Application_Model_DbTable_Profil');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Profil $profil)
    {
       $data = array(
            'nomProfil'   => $profil->getNomProfil(),
            'typeProfil' => $profil->getTypeProfil(),
            'iconeProfil' => $profil->getIconeProfil(),
        );
 
        if (null === ($idProfil = $profil->getId())) {
            unset($data['idProfil']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('idProfil = ?' => $idProfil));
        }
    }
 
    public function find($id, Application_Model_Profil $profil)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $profil->setIdProfil($row->idProfil)
                ->setNomProfil($row->nomProfil)
                ->setTypeProfil($row->typeProfil)
                ->setIconeProfil($row->iconeProfil);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Profil();
            $entry->setIdProfil($row->idProfil);
            $entry->setNomProfil($row->nomProfil);
            $entry->setTypeProfil($row->typeProfil);
            $entry->setIconeProfil($row->iconeProfil);
            $entries[] = $entry;
        }
        return $entries;
    }

}


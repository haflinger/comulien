<?php

class Application_Model_OrganismeMapper
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
            $this->setDbTable('Application_Model_DbTable_Organisme');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Organisme $organisme)
    {
       $data = array(
            'nomOrga'   => $organisme->getNomOrga(),
            'descOrga' => $organisme->getDescOrga(),
            'logoOrga' => $organisme->getLogoOrga(),
        );
 
        if (null === ($idOrga = $organisme->getIdOrga())) {
            unset($data['idOrga']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('idOrga = ?' => $idOrga));
        }
    }
 
    public function find($id, Application_Model_Organisme $organisme)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $organisme->setIdOrga($row->idOrga)
                ->setNomOrga($row->nomOrga)
                ->setDescOrga($row->descOrga)
                ->setLogoOrga($row->logoOrga);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Organisme();
            $entry->setIdOrga($row->idOrga)
                ->setNomOrga($row->nomOrga)
                ->setDescOrga($row->descOrga)
                ->setLogoOrga($row->logoOrga);
            $entries[] = $entry;
        }
        return $entries;
    }


}


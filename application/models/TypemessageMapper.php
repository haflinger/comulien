<?php

class Application_Model_TypemessageMapper
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
            $this->setDbTable('Application_Model_DbTable_Typemessage');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Typemessage $typemessage)
    {
       $data = array(
            'lblTypeMsg'   => $typemessage->getLblTypeMsg()
        );
 
        if (null === ($idTypeMsg = $typemessage->getId())) {
            unset($data['idTypeMsg']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('idTypeMsg = ?' => $idTypeMsg));
        }
    }
 
    public function find($id, Application_Model_Typemessage $typemessage)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $typemessage->setIdTypeMsg($row->idTypeMSg);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Typemessage();
            $entry->setIdTypeMsg($row->idTypeMsg)
                ->setlblTypeMsg($row->lblTypeMsg);
            $entries[] = $entry;
        }
        return $entries;
    }


}


<?php

class Application_Model_MessageMapper
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
            $this->setDbTable('Application_Model_DbTable_Message');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Message $message)
    {
       $data = array(
            'lblMessage'   => $message->getLblMessage(),
            'dateEmissionMsg' => $message->getDateEmissionMsg(),
            'dateActiviteMsg' => $message->getDateActiviteMsg(),
           'estActifMsg' => $message->getEstActifMsg()
        );
 
        if (null === ($idMessage = $message->getIdMessage())) {
            unset($data['idMessage']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('idMessage = ?' => $idMessage));
        }
    }
 
    public function find($id, Application_Model_Message $message)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $message->setIdMessage($row->idMessage)
                ->setLblMessage($row->lblMessage)
                ->setDateEmissionMsg($row->dateEmissionMsg)
                ->setDateActiviteMsg($row->dateActiviteMsg)
                ->setEstActifMsg($row->estActifMsg);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Message();
            $entry->setIdMessage($row->idMessage)
                ->setLblMessage($row->lblMessage)
                ->setDateEmissionMsg($row->dateEmissionMsg)
                ->setDateActiviteMsg($row->dateActiviteMsg)
                ->setEstActifMsg($row->estActifMsg);
            $entries[] = $entry;
        }
        return $entries;
    }


}


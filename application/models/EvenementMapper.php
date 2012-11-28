<?php

class Application_Model_EvenementMapper
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
            $this->setDbTable('Application_Model_DbTable_Evenement');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Evenement $evenement)
    {
       $data = array(
            'titreEvent'   => $evenement->getTitreEvent(),
            'numEvent' => $evenement->getNumEvent(),
            'descEvent' => $evenement->getDescEvent(),
            'logoEvent'   => $evenement->getLogoEvent(),
            'dateDebutEvent' => $evenement->getDateDebutEvent(),
            'dateFinEvent' => $evenement->getDateFinEvent(),
            'delaiPersistence' => $evenement->getDelaiPersistence()
        );
 
        if (null === ($idEvent = $evenement->getIdEvent())) {
            unset($data['idEvent']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('idEvent = ?' => $idEvent));
        }
    }
 
    public function find($id, Application_Model_Evenement $evenement)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $evenement->setIdEvent($row->idEvent)
                ->setTitreEvent($row->titreEvent)
                ->setNumEvent($row->numEvent)
                ->setDescEvent($row->descEvent)
                ->setLogoEvent($row->logoEvent)
                ->setDateDebutEvent($row->dateDebutEvent)
                ->setDateFinEvent($row->dateFinEvent)
                ->setDelaiPersistence($row->delaiPersistence);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Evenement();
            $entry->setIdEvent($row->idEvent)
                ->setTitreEvent($row->titreEvent)
                ->setNumEvent($row->numEvent)
                ->setDescEvent($row->descEvent)
                ->setLogoEvent($row->logoEvent)
                ->setDateDebutEvent($row->dateDebutEvent)
                ->setDateFinEvent($row->dateFinEvent)
                ->setDelaiPersistence($row->delaiPersistence);
            $entries[] = $entry;
        }
        return $entries;
    }


}


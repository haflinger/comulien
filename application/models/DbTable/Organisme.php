<?php

class Application_Model_DbTable_Organisme extends Zend_Db_Table_Abstract
{

    protected $_name = 'organisme';
    protected $_rowClass = 'Application_Model_Row_OrganismeRow';
    protected $_rowsetClass = 'Application_Model_Rowset_OrganismeRowset';
    protected $_dependentTables = array('Application_Model_DbTable_Distinguer');
    
    public function getOrganismeParID($idOrga)
    {
        $idOrga = (int)$idOrga;
        $row = $this->fetchRow('idOrga = ' . $idOrga);
        if (!$row) {
            throw new Exception("Could not find row $idOrga");
        }
        return $row;
    }
}


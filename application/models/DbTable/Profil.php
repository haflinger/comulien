<?php

class Application_Model_DbTable_Profil extends Zend_Db_Table_Abstract
{
    protected $_name = 'profil';
    protected $_rowClass = 'Application_Model_Row_ProfilRow';
    protected $_rowsetClass = 'Application_Model_Rowset_ProfilRowset';
    protected $_dependentTables = array('Application_Model_DbTable_Distinguer');
}


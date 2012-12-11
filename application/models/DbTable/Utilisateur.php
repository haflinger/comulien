<?php

class Application_Model_DbTable_Utilisateur extends Zend_Db_Table_Abstract
{

    protected $_name = 'utilisateur';
    protected $_rowClass = 'Application_Model_Row_UtilisateurRow';
    protected $_rowsetClass = 'Application_Model_Rowset_UtilisateurRowset';
    protected $_dependentTables = array('Application_Model_DbTable_Apprecier');
}


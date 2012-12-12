<?php

class Application_Model_DbTable_Apprecier extends Zend_Db_Table_Abstract
{

    protected $_name = 'apprecier';
    protected $_rowClass = 'Application_Model_Row_ApprecierRow';
    protected $_rowsetClass = 'Application_Model_Rowset_ApprecierRowset';
    protected $_referenceMap = array(
        'Message' => array(
            'columns' => 'idMessage',
            'refTableClass' => 'Application_Model_DbTable_Message',
            'refColumns' => 'idMessage'
        ),
        'Utilisateur' => array(
            'columns' => 'idUser',
            'refTableClass' => 'Application_Model_DbTable_Utilisateur',
            'refColumns' => 'idUser'
        )
    );


}


<?php

class Application_Model_DbTable_Evenement extends Zend_Db_Table_Abstract
{

    protected $_name = 'evenement';
    protected $_rowClass = 'Application_Model_Row_EvenementRow';
    protected $_referenceMap    = array(
        'creer' => array(
            'columns'           => 'idOrga',
            'refTableClass'     => 'Application_Model_DbTable_Organisme',
            'refColumns'        => 'idOrga'
        ));
}


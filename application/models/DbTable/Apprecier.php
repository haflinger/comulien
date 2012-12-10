<?php

class Application_Model_DbTable_Apprecier extends Zend_Db_Table_Abstract
{

    protected $_name = 'apprecier';
    protected $_referenceMap = array(
        'Oeuvre' => array(
            'columns' => 'IDCREATION',
            'refTableClass' => 'Application_Model_DbTable_Oeuvre',
            'refColumns' => 'IDCREATION'
        ),
        'Auteur' => array(
            'columns' => 'IDAUTEUR',
            'refTableClass' => 'Application_Model_DbTable_Auteur',
            'refColumns' => 'IDAUTEUR'
        )
    );


}


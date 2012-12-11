<?php

class Application_Model_DbTable_Distinguer extends Zend_Db_Table_Abstract
{

    protected $_name = 'distinguer';
    protected $_referenceMap = array(
        'Profil' => array(
            'columns' => 'idProfil',
            'refTableClass' => 'Application_Model_DbTable_Profil',
            'refColumns' => 'idProfil'
        ),
        'Utilisateur' => array(
            'columns' => 'idUser',
            'refTableClass' => 'Application_Model_DbTable_Utilisateur',
            'refColumns' => 'idUser'
        ),
        'Organisme' => array(
            'columns' => 'idOrga',
            'refTableClass' => 'Application_Model_DbTable_Organisme',
            'refColumns' => 'idOrga'
        )
    );

}


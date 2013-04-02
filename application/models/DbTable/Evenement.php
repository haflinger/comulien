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
    
    public function getEvenementParID($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('idEvent = ' . $id);
//        if (!$row) {
//            throw new Exception("Could not find row $id");
//        }
        return $row;
    }
    
    public function setEvent($idOrga,$titreEvent,$numEvent,$descEvent,$logoEvent,$dateDebutEvent,$dateFinEvent,$delaiPersistence){
        $data = array(
            'idOrga' => $idOrga,
            'titreEvent' => $titreEvent,
            'numEvent' => $numEvent,
            'descEvent' => $descEvent,
            'logoEvent' => $logoEvent,
            'dateDebutEvent' => $dateDebutEvent,
            'dateFinEvent' => $dateFinEvent,
            'delaiPersistence' => $delaiPersistence
        );
        $this->insert($data);
    }

}


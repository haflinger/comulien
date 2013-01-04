<?php

class Application_Model_DbTable_Distinguer extends Zend_Db_Table_Abstract
{
    protected $_name = 'distinguer';
    protected $_rowClass = 'Application_Model_Row_DistinguerRow';
    protected $_rowsetClass = 'Application_Model_Rowset_DistinguerRowset';
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
    
    public function getProfils($IDuser,$IDorga){
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('d'=>'distinguer'),'d.idProfil')
                ->join(array('p'=>'profil'),
                        'd.idProfil = p.idProfil',
                        'p.nomProfil')
                ->where('idUser=?',$IDuser)  
                ->where('idOrga=?',$IDorga)
                ->order('idUser ASC');
        $result = $this->fetchAll($select);
        $dist = array(0=>'Utilisateur');
 
        while ($result->valid()) {
            $d = $result->current();
            $dist[$d->idProfil] = $d->nomProfil;  
            $result->next();
        }
 
        $result->rewind();
 
        return $dist;
//        
//        $retour = array(0=>'Utilisateur');
//        $retour[1]='autre';
//        foreach ($result as $key=>$value) {
//            $retour[] = $value[1];
//        }
//        return $retour;
//        return $result;
    }
}


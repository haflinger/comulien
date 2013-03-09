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
    }
    
    public function getAllDistinctionForUser($idUser){
//        select o.nomOrga as 'nomOrga',o.descOrga as 'descOrga',o.logoOrga as 'logoOrga',
//        d.droitModeration as 'moderateur', d.nomFonction as 'nomFonction',
//        p.nomProfil as 'nomProfil',
//        u.loginUser
//        from distinguer d
//        inner join organisme o on o.idOrga = d.idOrga
//        inner join profil p on p.idProfil = d.idProfil
//        inner join utilisateur u on u.idUser = d.idUser
//        where d.idUser=1
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('d'=>'distinguer'),array('droitModeration', 'nomFonction'))
                ->joinInner(array('p'=>'profil'),'d.idProfil = p.idProfil',array('nomProfil'))
                ->joinInner(array('u'=>'utilisateur'),'d.idUser = u.idUser',array('loginUser'))
                ->joinInner(array('o'=>'organisme'),'d.idOrga = o.idOrga',array('nomOrga','descOrga','logoOrga'))
                ->where('u.idUser=?',$idUser);
        $result = $this->fetchAll($select);
        Zend_Registry::set('sql',$select->assemble());
        return $result;



    }
}


<?php

class Application_Model_DbTable_Message extends Zend_Db_Table_Abstract
{

    protected $_name = 'message';
    protected $_rowClass = 'Application_Model_Row_MessageRow';
    protected $_rowsetClass = 'Application_Model_Rowset_MessageRowset';
    protected $_dependentTables = array('Application_Model_DbTable_Apprecier');
    protected $_referenceMap    = array(
        'concerne' => array(
            'columns'           => 'idEvent',
            'refTableClass'     => 'Application_Model_DbTable_Evenement',
            'refColumns'        => 'idEvent'
        ),
        'correspondre' => array(
            'columns'           => 'idTypeMsg',
            'refTableClass'     => 'Application_Model_DbTable_TypeMessage',
            'refColumns'        => 'idTypeMsg'
        ),
        'caracteriser' => array(
            'columns'           => 'idProfil',
            'refTableClass'     => 'Application_Model_DbTable_Profil',
            'refColumns'        => 'idProfil'
        ),
        'emettre' => array(
            'columns'           => 'idUser_emettre',
            'refTableClass'     => 'Application_Model_DbTable_Utilisateur',
            'refColumns'        => 'idUser'
        ),
        'moderer' => array(
            'columns'           => 'idUser_moderer',
            'refTableClass'     => 'Application_Model_DbTable_Utilisateur',
            'refColumns'        => 'idUser'
        ));

    public function messagesOrganisateur(Application_Model_Row_EvenementRow $evenement)
    {
        $select = $this->select()
                     ->where('idEvent=?',$evenement->idEvent)   //dans l'évènement
                     ->where('idProfil=1')                      //les organisateurs
                     ->where('estActifMsg=1')                   //seuls les messages actifs
                     ->order('dateEmissionMsg DESC');           //classés par date d'émission les plus récents en premier
        $result = $this->fetchAll($select);
        return $result;
    }
    
    public function messagesTous(Application_Model_Row_EvenementRow $evenement){
        $select = $this->select()
                     ->where('idEvent=?',$evenement->idEvent)  //dans l'évènement
                     ->where('estActifMsg=1')                  //seuls les messages actifs
                     ->order('dateActiviteMsg DESC');          //classés par date d'activité la plus récente en premier
        $result = $this->fetchAll($select);
        return $result;
    }
    
    /**
     * Récupère un message mentionné par son ID
     * @param type $id
     */
    public function getMessage($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow(array('idMessage = ?'=>$id));
        if (!$row) {
           throw new Exception("Could not find row $id");
        }
        return $row;
    }
    /**
     * change l'état d'activité du message
     * @param int $idMessage l'identifiant du message
     * @param UtilisateurRow $moderateur l'utilisateur qui procède à la modération
     * @param int $actif 1 ou 0 selon que l'on souhaite activer ou désactiver le message
     */
    public function modererMessage($idMessage,$idUser,$actif){
        //todo : réfléchir sur l'utilité/le besoin de modérer en appelant une procédure stockée
        $data = array (
            'estActifMsg'=>$actif,
            'idUser_Moderer'=>($actif=='0') ? $idUser : null,
            );
        $where = array();
        $where['idMessage = ?'] = $idMessage;
        
        $this->update($data, $where);
    }
    
    public function posterMessage($data){
        $this->insert($data);
    }
}


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

    public function messagesOrganisateur(Application_Model_Row_EvenementRow $evenement, $showActifOnly = true)
    {
        $select = $this->select()
                     ->where('idEvent=?',$evenement->idEvent)   //dans l'évènement
                     ->where('idProfil=1')                      //les organisateurs
                     ->order('dateEmissionMsg DESC');           //classés par date d'émission les plus récents en premier
        //les messages actifs seulement ?
        if ($showActifOnly) {
            $select->where('estActifMsg=1');              //seuls les messages actifs
        }
        $result = $this->fetchAll($select);
        return $result;
    }
    
    public function messagesTous(Application_Model_Row_EvenementRow $evenement, $showAll ){
        $select = $this->select()
                ->where('idEvent=?',$evenement->idEvent) //dans l'évènement
                ->order('dateActiviteMsg DESC');         //classés par date d'activité la plus récente en premier
                
        //les messages actifs seulement ?
        if (!$showAll) {
            $select->where('estActifMsg=?','1'); //seuls les messages actifs
        }
        
        $result = $this->fetchAll($select);
        return $result;
    }
    
    public function reponsesMessage($idMessage, $showAll = false){
        $result = null;
        $select = $this->select()
                ->where('idMessage_reponse=?',$idMessage)
                ->order('dateEmissionMsg DESC');
        //les messages actifs seulement ?
        if (!$showAll) {
            $select->where('estActifMsg=?','1'); //seuls les messages actifs
        }
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
     * Récupère les réponses d'un message passé par ID
     * @param type $id
     */
    public function getReponses($id){
        $id= (int)$id;
        $rowset = $this->fetchAll(array('idMessage_reponse = ?'=>$id));
        if(!rowset){
            throw  new Exception("Aucune réponse trouvée");
        }
        return $rowset;
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
    
    public function apprecierMessage(Application_Model_Row_MessageRow $message, Application_Model_Row_UtilisateurRow $utilisateur, $note){
        
       //on va écrire dans la base selon les situations 
        //on instancie la table 'apprecier'
        $table = new Application_Model_DbTable_Apprecier();
        //on créé un jeu de données
        $data = array(
            'idUser'=>$utilisateur->idUser,
            'idMessage'=>$message->idMessage,
            'evaluation'=>$note
                );
        //on créé la clause where (pour les update et fetch
        $where = array();
        $where['idUser = ?'] = $data['idUser'];
        $where['idMessage = ?'] = $data['idMessage'];

        //on teste l'existence d'une entrée
        if( is_null($table->fetchRow($where)) ){
            //la note 0 n'insère ni n'update rien
            if ($note==0) {
                //passe
            }else{
                //une note et pas d'entrée dans la table : on insère
                $table->insert($data);
            }
        }else{
            if ($note==0) {
                //note vide, on supprime
                $table->delete($where);
            }else{
                //une note et une entrée dans la table : on update
                $table->update($data, $where);
            }
            
        }
        
        //TODO il faut actualiser la date d'activité du message lorsque note=1
        if ($note==1) {
            $maintenant = Zend_Date::now();
            $message->dateActiviteMsg = $maintenant->toString('YYYY-MM-DD HH:mm:ss S');
            $message->save();
        }
        return;
    }
}


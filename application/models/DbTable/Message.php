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
    
    /**
     * Retourne les messages de l'évènement
     * @param Application_Model_Row_EvenementRow $evenement
     * @param bool $showAll indique si les messages modérés doivent être affichés
     * @return type
     */
    public function messagesTous($idEvent, $showAll, $pageNum = 1, $nbItemParPage = 5 ,$dateRef = null){
        //TODO : job in progress : utiliser la date pour la pagination
        if (is_null($dateRef)) {
            //pas de date de référence : messages plus anciens que maintenant
            $dateRef = Zend_Date::now();
        } 
        
        //$dateRef = Zend_Date::now()->subDay(4);//todo pour les tests
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('m'=>'message'),
                        array('idEvent','idUser_moderer','idMessage','idUser_emettre','idTypeMsg','lblMessage','idProfil','estActifMsg','dateActiviteMsg'))
                ->joinLeft(array('a'=>'apprecier'),
                        'm.idMessage = a.idMessage',
                        array('sum(if(a.evaluation>0,1,0)) as like','sum(if(a.evaluation<0,1,0)) as dislike'))
                ->joinInner(array('u'=>'utilisateur'),
                        'm.idUser_emettre = u.idUser',
                        array('loginUser','emailUser'))
                //->where('m.idMessage_reponse=?',$idMessage)
                ->where('m.idMessage_reponse IS NULL')          //ne pas prendre les réponses
                ->where('m.idEvent=?',$idEvent)                 //les messages de l'évènement
                ->where('m.dateActiviteMsg<?',$dateRef->toString('yyyy-MM-dd HH:mm:ss S'))         //les message antérieurs à la date fournie
                ->group('m.idMessage','like','disklike')
                ->order('dateActiviteMsg DESC');        
        //les messages actifs seulement ?
        if (!$showAll) {
            $select->where('m.estActifMsg=?','1'); //seuls les messages actifs
        }
        //$select->limitPage($pageNum, $nbItemParPage);
        $select->limit($nbItemParPage);
        $result = $this->fetchAll($select);
        Zend_Registry::set('sql',$select->assemble());
        return $result;
    }

    
    
    public function reponsesMessage($idMessage, $idEvent, $showAll = false ,$pageNum = 1, $nbItemParPage = 5 , $dateRef = null){
        if (is_null($dateRef)) {
            //pas de date de référence : messages plus anciens que maintenant
            $dateRef = Zend_Date::now();
        } 
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('m'=>'message'),
                        array('idEvent','idUser_moderer','idMessage','idUser_emettre','idTypeMsg','lblMessage','idProfil','estActifMsg','dateActiviteMsg'))
                ->joinLeft(array('a'=>'apprecier'),
                        'm.idMessage = a.idMessage',
                        array('sum(if(a.evaluation>0,1,0)) as like','sum(if(a.evaluation<0,1,0)) as dislike'))
                ->joinInner(array('u'=>'utilisateur'),
                        'm.idUser_emettre = u.idUser',
                        array('loginUser','emailUser'))
                ->where('m.idMessage_reponse=?',$idMessage)
                ->where('m.idEvent=?',$idEvent)
                ->where('m.dateActiviteMsg<?',$dateRef->toString('yyyy-MM-dd HH:mm:ss S'))         //les message antérieurs à la date fournie
                ->group('m.idMessage','like','disklike')
                ->order('dateEmissionMsg DESC');
        //les messages actifs seulement ?
        if (!$showAll) {
            $select->where('m.estActifMsg=?','1'); //seuls les messages actifs
        }
        $select->limit( $nbItemParPage);
        $result = $this->fetchAll($select);
        Zend_Registry::set('sql',$select->assemble());
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
    
    /**
     * persiste le message. La date est celle de l'instant
     * @param int $idUser : l'ID de l'utilisateur
     * @param int $idTypeMsg : l'ID du type de message (0 obligatoirement pour le moment)
     * @param int $idEvent : l'ID de l'évènement
     * @param string $message : le message à persister
     * @param int $profil : l'id du profil utilisé pour persister le message
     */
    public function posterMessage($idUser,$idTypeMsg,$idEvent,$message,$profil,$idMessageParent=null)
    {
        $dateheure = Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss S');
        $data = array(
            'idUser_emettre' => $idUser,
            'idTypeMsg' => $idTypeMsg,//inutilisé pour le moment mais obligatoire
            'idEvent' => $idEvent,
            'lblMessage' => $message,
            'idProfil' => $profil,
            'dateEmissionMsg' => $dateheure,
            'dateActiviteMsg' => $dateheure
            );

        if ($idMessageParent!='') {
            $data['idMessage_reponse'] = $idMessageParent;
        }

        //todo : updater le message parent -> utiliser un trigger
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

        $appreciation = $table->fetchRow($where);
        if (!is_null($appreciation)) {
            $ancienneNote = $appreciation->evaluation;
        }
        else{
            $ancienneNote = 0;
        }
        //on teste l'existence d'une entrée
        if( is_null($appreciation) ){
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
        
        //la date d'activité d'un message est actualisé lorsque la nouvelle note 
        //dépasse la précédente
        if($note>$ancienneNote){
            $maintenant = Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss S');
            $message->dateActiviteMsg = $maintenant;
            $message->save();
        }
        return;
    }
}


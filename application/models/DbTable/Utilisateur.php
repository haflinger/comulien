<?php

class Application_Model_DbTable_Utilisateur extends Zend_Db_Table_Abstract
{

    protected $_name = 'utilisateur';
    protected $_rowClass = 'Application_Model_Row_UtilisateurRow';
    protected $_rowsetClass = 'Application_Model_Rowset_UtilisateurRowset';
    protected $_dependentTables = array('Application_Model_DbTable_Apprecier','Application_Model_DbTable_Distinguer');

    public function addUser($login, $email, $password, $nom , $prenom) {
        $maintenant = Zend_Date::now();
        $dateheure = $maintenant->toString('yyyy-MM-dd HH:mm:ss S');
        $data = array(
            'loginUser' => $login,
            'emailUser' => $email,
            'pswUser' => md5($password),
            'nomUser' => $nom,
            'prenomUser' => $prenom,
            'dateInscriptionUser' => $dateheure
        );
        $this->insert($data);
    }
    
    public function updateUser($login, $email, $password, $nom , $prenom) {
        //TODO : voir si l'update appartient à Utilisateur_Row
        $data = array(
            'loginUser' => $login,          //un login peut t'il être modifié
            'emailUser' => $email,          
            'pswUser' => md5($password),
            'nomUser' => $nom,
            'prenomUser' => $prenom
            //'dateInscriptionUser' => $dateheure
        );
        $where = $this->getAdapter()->quoteInto('loginUser = ?', $login);
        
        $this->update($data,$where);
    }
}


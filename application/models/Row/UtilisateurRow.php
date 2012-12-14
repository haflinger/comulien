<?php

/**
 * Description of UtilisateurRow
 *
 * @author Fred H
 */
class Application_Model_Row_UtilisateurRow extends Zend_Db_Table_Row_Abstract
{
    protected $messages = null;
    protected $organismes = null;
    protected $distinctions = null;
    protected $apprecier = null;
    protected $messageEmis = null;
    
     /**
     * @return les messages appréciés par l'utilisateur
     */
    public function getMessages()
    {
        if (!$this->messages) {
            $this->messages = $this->findManyToManyRowset(
                'Application_Model_DbTable_Message',   
                'Application_Model_DbTable_Apprecier');  
        }
 
        return $this->messages;
    }

     /**
     * @return les organismes de l'utilisateur
     */
    public function getOrganismes()
    {
        if (!$this->organismes) {
            $this->organismes = $this->findManyToManyRowset(
                'Application_Model_DbTable_Organisme',   // match table
                'Application_Model_DbTable_Distinguer');  // join table
        }
        return $this->organismes;
    }
    
     /**
     * @return les distinction (relation ternaire)
     */
    public function getDistinctions()
    {
        if (!$this->distinctions) {
            $this->distinctions = $this->findDependentRowset(
                'Application_Model_DbTable_Distinguer');  // join table
        }
        return $this->distinctions;
    }
    
     /**
     * @return les appreciations
     */
    public function getAppreciers()
    {
        if (!$this->apprecier) {
            $this->apprecier = $this->findDependentRowset(
                'Application_Model_DbTable_Apprecier');  
        }
        return $this->apprecier;
    }
    
     /**
     * @return les messages emis par l'utilisateur
     */
    public function getMessagesEmis()
    {
        if (!$this->messageEmis) {
            $this->messageEmis = $this->findDependentRowset(
                'Application_Model_DbTable_Message'); 
        }
        return $this->messageEmis;
    }
    
    
    //getGravatar : récupère si il existe, l'avatar correspondant à l'adresse email sur le service gravatar
    public function getGravatar(){
        //TODO : cette fonction est déjà prévue par Zend  ...
        //  par le biais d'un helper à utiliser dans les vues : echo $this->gravatar('example@example.com');
        //  voir http://framework.zend.com/manual/1.12/fr/zend.view.helpers.html
        $email = $this->emailUser;
        $default = "http://www.comulien.com/avatar.jpg"; //TODO : trouver un avatar par défaut
        $size = 40;
        $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
        return $grav_url;

    }
}


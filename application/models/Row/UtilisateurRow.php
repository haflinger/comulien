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
    
    public function estModerateur($Event){
        //solution n'utilisant que les méthodes du UtilisateurRow
        //autre solution à tester : faire une requête si possible dans le row, 
        // ou sinon faire une requête dans le dbtable
        $orgaID = $Event->idOrga;
        $distinctions = $this->getDistinctions();
        $moderateur = false;
        foreach ($distinctions as $dist){
            $org = $dist->getOrganisme()->idOrga;
            if ($org==$orgaID) {
                $moderateur = $dist->droitModeration=='1';
            }
        }
        return $moderateur;
    }
    
    
    public function getProfils($idOrga){
        //cette méthode devrait servir pour les ACL
        //Les rôles à retourner seront :
        // anonyme, identifie, utilisateur, corporate, organisateur 
        $tableDistinguer = new Application_Model_DbTable_Distinguer();
        $select = $tableDistinguer->select()
                ->where('idUser = ?' ,$this->idUser)
                ->where('idOrga = ?' ,$idOrga);
        return $tableDistinguer->fetchAll($select);
        
    }
    
//    public function getRole($idOrga){
//        $profils = $this->getProfils($idOrga);
//        $role = 'visiteur';
//        if ($profils->count()>0) {
//            $role = 'identifie';
//            //TODO : préciser s'il s'agit d'un corp ou orga
//            //  (attention le cas ou l'utilisateur est à la fois corp ou orga)
//        }
//        else{
//            $role = 'utilisateur';
//        }
//        return $role;
//    }
//    
    public function getRole($idOrga){
        $idProfil = $this->getDistinction($idOrga);
        $role = null;
        switch ($idProfil) {
            case null:
                //identifié sans distinction
                $role = 'utilisateur';
                break;
            case 1:
                //Organisateur
                $role = 'organisateur';
                break;
            case 2:
                //Corporate
                $role = 'corporate';
                break;
            case 3:
                //Partenaire
                $role = 'partenaire';
                break;
            default:
                //aucun des cas
                $role = 'identifie';
         }
         return $role;
    }

    public function getDistinction($idOrga){
        $profils = $this->getProfils($idOrga);
        $profil = $profils->current();
        $idProfil = null;
        if (!is_null($profil)) {
            $idProfil = $profil->idProfil;
        }
        return $idProfil;
    }
}


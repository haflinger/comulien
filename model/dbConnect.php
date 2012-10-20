<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dbConnect
 *
 * @author Fred
 */
class dbConnect {
    private static $connexion = null;
    private $urlBase;
    private $nomBase;
    private $user;
    private $password;
    private $bdd;
    
     private function __construct($urlBase, $nomBase, $user, $password) {
        $this->urleBase = $urlBase;
        $this->nomBase = $nomBase;
        $this->user = $user;
        $this->password = $password;
        $this->bdd = $this->ConnexionBase();
    }
    
     // connexion à  la base de donnée avec les paramétres définis dans le constructeur
    private function ConnexionBase(){
        $base = 'mysql:host=' . $this->urlBase . ';dbname=' . $this->nomBase;
        try{
            $bdd = new PDO($base, $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
        return $bdd;
    }
    
    public static function getInstance() {
        if(is_null(self::$connexion)) {
            self::$connexion = new dbConnect('localhost', 'comulien', 'root', '');
        	//self::$connexion = new dbConnect('localhost', 'hackaton', 'hackaton', 'hackaton');
        }
        return self::$connexion;
    }
    
    // Execute la requête passée en argument et retourne un tableau avec le résultat de la requête
    public function ExecuteSelect($requete)
    {
        $resulRequete = $this->bdd -> prepare ($requete);
        $resulRequete -> execute();
        $data = $resulRequete -> fetchAll();
        $resulRequete -> closeCursor();
        return $data;
        
    }
    public function ExecuteSelectOne($requete)
    {
        $resulRequete = $this->bdd -> prepare ($requete);
        $resulRequete -> execute();
        $data = $resulRequete -> fetch();
        $resulRequete -> closeCursor();
        return $data;
    }
    
     // exécute la requête en insérant les données passées dans le tableau $tabData
    public function ExecuteInsert($strRequete, $tabData){
        $req = $this->bdd -> prepare($strRequete);
        $req->execute($tabData);
        $req -> closeCursor();
    }
    
    // exécute la requête en mettant à jour les données passées dans le tableau $tabData
    public function ExecuteUpdate($strRequete, $tabData){
        $req = $this->bdd->prepare($strRequete);
        $req->execute($tabData);
        $req -> closeCursor();
    }
    
    // exécute la requête en supprimant les données en fonction des paramètres passés
    // dans le tableau $tabData
    public function ExecuteDelete($strRequete, $tabData){
        $req = $this->bdd->prepare($strRequete);
        $req->execute($tabData);
        $req -> closeCursor();
    }
}

?>

<?php

class Application_Model_Utilisateur
{
    protected $idUser;
    protected $loginUser;
    protected $pswUser;
    protected $emailUser;
    protected $dateInscriptionUser;
    protected $nomUser;
    protected $prenomUser;
    protected $nbMsgUser;
    protected $nbApprouverUser;
    protected $estActifUser;
    
    function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        return $this->$method();
    }

    public function getIdUser() {
        return $this->idUser;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
        return $this;
    }

    public function getLoginUser() {
        return $this->loginUser;
    }

    public function setLoginUser($loginUser) {
        $this->loginUser = $loginUser;
        return $this;
    }

    public function getPswUser() {
        return $this->pswUser;
    }

    public function setPswUser($pswUser) {
        $this->pswUser = $pswUser;
        return $this;
    }

    public function getEmailUser() {
        return $this->emailUser;
    }

    public function setEmailUser($emailUser) {
        $this->emailUser = $emailUser;
        return $this;
    }

    public function getDateInscriptionUser() {
        return $this->dateInscriptionUser;
    }

    public function setDateInscriptionUser($dateInscriptionUser) {
        $this->dateInscriptionUser = $dateInscriptionUser;
        return $this;
    }

    public function getNomUser() {
        return $this->nomUser;
    }

    public function setNomUser($nomUser) {
        $this->nomUser = $nomUser;
        return $this;
    }

    public function getPrenomUser() {
        return $this->prenomUser;
    }

    public function setPrenomUser($prenomUser) {
        $this->prenomUser = $prenomUser;
        return $this;
    }

    public function getNbMsgUser() {
        return $this->nbMsgUser;
    }

    public function setNbMsgUser($nbMsgUser) {
        $this->nbMsgUser = $nbMsgUser;
        return $this;
    }

    public function getNbApprouverUser() {
        return $this->nbApprouverUser;
    }

    public function setNbApprouverUser($nbApprouverUser) {
        $this->nbApprouverUser = $nbApprouverUser;
        return $this;
    }

    public function getEstActifUser() {
        return $this->estActifUser;
    }

    public function setEstActifUser($estActifUser) {
        $this->estActifUser = $estActifUser;
        return $this;
    }
    
    //getGravatar : récupère si il existe, l'avatar correspondant à l'adresse email sur le service gravatar
    public function getGravatar(){
        $email = $this->emailUser;
        $default = "http://www.comulien.com/avatar.jpg"; //TODO : trouver un avatar par défaut
        $size = 40;
        $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
        return $grav_url;

    }
}


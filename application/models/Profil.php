<?php

class Application_Model_Profil
{
    protected $idProfil;
    protected $nomProfil;
    protected $typeProfil;
    protected $iconeProfil;
    
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
            throw new Exception('Invalid profil property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid profil property');
        }
        return $this->$method();
    }

    public function getIdProfil() {
        return $this->idProfil;
    }

    public function setIdProfil($idProfil) {
        $this->idProfil = $idProfil;
    }

    public function getNomProfil() {
        return $this->nomProfil;
    }

    public function setNomProfil($nomProfil) {
        $this->nomProfil = $nomProfil;
    }

    public function getTypeProfil() {
        return $this->typeProfil;
    }

    public function setTypeProfil($typeProfil) {
        $this->typeProfil = $typeProfil;
    }

    public function getIconeProfil() {
        return $this->iconeProfil;
    }

    public function setIconeProfil($iconeProfil) {
        $this->iconeProfil = $iconeProfil;
    }


}


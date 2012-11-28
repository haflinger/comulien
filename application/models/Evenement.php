<?php

class Application_Model_Evenement
{
    protected $idEvent;
    protected $titreEvent;
    protected $numEvent;
    protected $descEvent;
    protected $logoEvent;
    protected $dateDebutEvent;
    protected $dateFinEvent;
    protected $delaiPersistence;

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
            throw new Exception('Invalid evenement property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid evenement property');
        }
        return $this->$method();
    }
    
    public function getIdEvent() {
        return $this->idEvent;
    }

    public function setIdEvent($idEvent) {
        $this->idEvent = $idEvent;
        return $this;
    }

    public function getTitreEvent() {
        return $this->titreEvent;
    }

    public function setTitreEvent($titreEvent) {
        $this->titreEvent = $titreEvent;
        return $this;
    }

    public function getNumEvent() {
        return $this->numEvent;
    }

    public function setNumEvent($numEvent) {
        $this->numEvent = $numEvent;
        return $this;
    }

    public function getDescEvent() {
        return $this->descEvent;
    }

    public function setDescEvent($descEvent) {
        $this->descEvent = $descEvent;
        return $this;
    }

    public function getLogoEvent() {
        return $this->logoEvent;
    }

    public function setLogoEvent($logoEvent) {
        $this->logoEvent = $logoEvent;
        return $this;
    }

    public function getDateDebutEvent() {
        return $this->dateDebutEvent;
    }

    public function setDateDebutEvent($dateDebutEvent) {
        $this->dateDebutEvent = $dateDebutEvent;
        return $this;
    }

    public function getDateFinEvent() {
        return $this->dateFinEvent;
    }

    public function setDateFinEvent($dateFinEvent) {
        $this->dateFinEvent = $dateFinEvent;
        return $this;
    }

    public function getDelaiPersistence() {
        return $this->delaiPersistence;
    }

    public function setDelaiPersistence($delaiPersistence) {
        $this->delaiPersistence = $delaiPersistence;
        return $this;
    }


}


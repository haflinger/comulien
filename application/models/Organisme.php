<?php

class Application_Model_Organisme
{
    protected $idOrga;
    protected $nomOrga;
    protected $descOrga;
    protected $logoOrga;

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
            throw new Exception('Invalid organisme property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid organisme property');
        }
        return $this->$method();
    }
    
    public function getIdOrga() {
        return $this->idOrga;
    }

    public function setIdOrga($idOrga) {
        $this->idOrga = $idOrga;
        return $this;
    }

    public function getNomOrga() {
        return $this->nomOrga;
    }

    public function setNomOrga($nomOrga) {
        $this->nomOrga = $nomOrga;
        return $this;
    }

    public function getDescOrga() {
        return $this->descOrga;
    }

    public function setDescOrga($descOrga) {
        $this->descOrga = $descOrga;
        return $this;
    }

    public function getLogoOrga() {
        return $this->logoOrga;
    }

    public function setLogoOrga($logoOrga) {
        $this->logoOrga = $logoOrga;
        return $this;
    }


}


<?php

class Application_Model_Message
{
    protected $idMessage;
    protected $lblMessage;
    protected $dateEmissionMsg;
    protected $dateActiviteMsg;
    protected $estActifMsg;
    
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
            throw new Exception('Invalid message property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid message property');
        }
        return $this->$method();
    }

    public function getIdMessage() {
        return $this->idMessage;
    }

    public function setIdMessage($idMessage) {
        $this->idMessage = $idMessage;
        return $this;
    }

    public function getLblMessage() {
        return $this->lblMessage;
    }

    public function setLblMessage($lblMessage) {
        $this->lblMessage = $lblMessage;
        return $this;
    }

    public function getDateEmissionMsg() {
        return $this->dateEmissionMsg;
    }

    public function setDateEmissionMsg($dateEmissionMsg) {
        $this->dateEmissionMsg = $dateEmissionMsg;
        return $this;
    }

    public function getDateActiviteMsg() {
        return $this->dateActiviteMsg;
    }

    public function setDateActiviteMsg($dateActiviteMsg) {
        $this->dateActiviteMsg = $dateActiviteMsg;
        return $this;
    }

    public function getEstActifMsg() {
        return $this->estActifMsg;
    }

    public function setEstActifMsg($estActifMsg) {
        $this->estActifMsg = $estActifMsg;
        return $this;
    }


}


<?php

class Application_Model_Typemessage
{
    protected $idTypeMsg;
    protected $lblTypeMsg;
    
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
            throw new Exception('Invalid typemessage property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid typemessage property');
        }
        return $this->$method();
    }

    public function getIdTypeMsg() {
        return $this->idTypeMsg;
    }

    public function setIdTypeMsg($idTypeMsg) {
        $this->idTypeMsg = $idTypeMsg;
        return $this;
    }

    public function getLblTypeMsg() {
        return $this->lblTypeMsg;
    }

    public function setLblTypeMsg($lblTypeMsg) {
        $this->lblTypeMsg = $lblTypeMsg;
        return $this;
    }



}


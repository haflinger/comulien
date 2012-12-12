<?php

/**
 * Description of DistinguerRowset
 *
 * @author Fred H
 */
class Application_Model_Rowset_DistinguerRowset extends Zend_Db_Table_Rowset_Abstract
{
     /**
     * @return un tableau de distinction (relation ternaire)
     */
    public function getAsArray()
    {
        $dist = array();
 
        while ($this->valid()) {
            $d = $this->current();
            $dist[] = $d;  
            $this->next();
        }
 
        $this->rewind();
 
        return $dist;
    }
}

?>

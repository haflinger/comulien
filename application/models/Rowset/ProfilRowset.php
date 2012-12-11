<?php

/**
 * Description of ProfilRowset
 *
 * @author Fred H
 */
class Application_Model_Rowset_ProfilRowset extends Zend_Db_Table_Rowset_Abstract
{
     /**
     * @return un tableau de profils
     */
    public function getAsArray()
    {
        $profils = array();
 
        while ($this->valid()) {
            $pro = $this->current();
            $profils[] = $pro;  
            $this->next();
        }
 
        $this->rewind();
 
        return $profils;
    }
}

?>

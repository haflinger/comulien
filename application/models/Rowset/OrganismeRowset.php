<?php

/**
 * Description of OrganismeRowset
 *
 * @author Fred H
 */
class Application_Model_Rowset_OrganismeRowset extends Zend_Db_Table_Rowset_Abstract
{
     /**
     * @return un tableau d'organismes
     */
    public function getAsArray()
    {
        $orgas = array();
 
        while ($this->valid()) {
            $orga = $this->current();
            $orgas[] = $orga;  
            $this->next();
        }
 
        $this->rewind();
 
        return $orgas;
    }
}

?>

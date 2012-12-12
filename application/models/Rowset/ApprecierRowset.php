<?php
/**
 * Description of ApprecierRowset
 *
 * @author Fred H
 */
class Application_Model_Rowset_ApprecierRowset  extends Zend_Db_Table_Rowset_Abstract
{
     /**
     * @return un tableau d'appreciation (CIM)
     */
    public function getAsArray()
    {
        $app = array();
 
        while ($this->valid()) {
            $a = $this->current();
            $app[] = $a;  
            $this->next();
        }
 
        $this->rewind();
 
        return $app;
    }
}

?>

<?php

class Application_Model_Rowset_MessageRowset extends Zend_Db_Table_Rowset_Abstract
{
     /**
     * @return un tableau de messages
     */
    public function getAsArray()
    {
        $messages = array();
 
        while ($this->valid()) {
            $mess = $this->current();
            $messages[] = $mess;  
            $this->next();
        }
 
        $this->rewind();
 
        return $messages;
    }

   
}

<?php

class Application_Model_Rowset_UtilisateurRowset extends Zend_Db_Table_Rowset_Abstract
{
        /**
     * @return un tableau d'utilisateurs
     */
    public function getAsArray()
    {
        $utilisateurs = array();
 
        while ($this->valid()) {
            $util = $this->current();
            $utilisateurs[] = $util;  
            $this->next();
        }
 
        $this->rewind();
 
        return $utilisateurs;
    }

   
}
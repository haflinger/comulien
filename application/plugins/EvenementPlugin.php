<?php

/**
 * gère l'évènement
 * !! INUTILISE POUR LE MOMENT !!
 * */
class Application_Plugin_EvenementPlugin extends Zend_Controller_Plugin_Abstract {

    const FAIL_AUTH_MODULE = 'default';
    const FAIL_AUTH_ACTION = 'login';
    const FAIL_AUTH_CONTROLLER = 'login';
    private $_evenement = null;
     
    public function getEvenement(){
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        //session active ?
        if (isset($bulleNamespace->checkedInEvent)) {
            $this->_evenement = $bulleNamespace->checkedInEvent;
            //La ligne qui suit est indispensable pour que les tables liées à la table évènement 
            //  soient mémorisées dans la session
            //  http://gustavostraube.wordpress.com/2010/05/11/zend-framework-cannot-save-a-row-unless-it-is-connected/
            $this->_evenement->setTable(new Application_Model_DbTable_Evenement());
        }
        else
        {
            $this->_evenement = null;
        }
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        parent::preDispatch($request);
        
        $this->getEvenement();
        
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        
        $front = Zend_Controller_Front::getInstance();
        $default = $front->getDefaultModule();
        
        
        if (is_null($this->_evenement ) ){
            if ( $module == $default && 
                    //tous les cas qui redirigent si pas d'évènement
                    ($controller=='evenement' && $action=='accueil') || 
                    ($controller!='evenement' && $controller!='utilisateur') ||
                    ($controller=='index' && $action=='index') 
                    
                ) {
                //pour tous ces cas, sans checkin, on redirige sur la page par défaut de l'évènement

                $request->setModuleName($module);
                $request->setControllerName('evenement');
                $request->setActionName('defaut');
                $front->returnResponse();
            }
        }
        
//        
//        $front = Zend_Controller_Front::getInstance();
//        $refAction = $front->getRequest()->getActionName();
//        $refController = $front->getRequest()->getControllerName();
//        $refModule = $front->getModuleControllerDirectoryName();
//        
//        $request->setModuleName($module);
//        $request->setControllerName($controller);
//        $request->setActionName($action);
    }
}
?>

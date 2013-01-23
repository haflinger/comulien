<?php

/**
 * Classe de création des ACL via un fichier de configuration INI
 * */
class Application_Plugin_PluginAuth extends Zend_Controller_Plugin_Abstract {

    /**
     * @var Zend_Auth instance 
     */
    private $_auth;

    /**
     * @var Zend_Acl instance 
     */
    private $_acl;

    /**
     *
     * @var Zend_Logger logger principal
     */
    private $_logger;
    /**
     * l'évènement en cours
     * @var rowset evenement 
     */
    private $_evenement = null;
    /**
     * Chemin de redirection lors de l'échec d'authentification
     */

    const FAIL_AUTH_MODULE = 'default';
    const FAIL_AUTH_ACTION = 'authentifier';
    const FAIL_AUTH_CONTROLLER = 'utilisateur';

    /**
     * Chemin de redirection lors de l'échec de contrôle des privilèges
     */
    const FAIL_ACL_MODULE = 'default';
    const FAIL_ACL_ACTION = 'index';
    const FAIL_ACL_CONTROLLER = 'index';

    /**
     * Constructeur
     */
    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
        $this->_auth = Zend_Auth::getInstance();
        $this->_logger = Zend_Registry::get("cml_logger");
        
    }
    
    
    /**
     * Vérifie les autorisations
     * Utilise _request et _response hérités et injectés par le FC
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
        if(Zend_Registry::isRegistered('checkedInEvent')){
            $this->_evenement = Zend_Registry::get('checkedInEvent');
        }
        if (is_null($this->_evenement)) {
            $role = 'visiteur';
        }else {
            $role = 'utilisateur';

            // is the user authenticated
            if ($this->_auth->hasIdentity()) {
                // yes ! we get his role
                $idUser = $this->_auth->getIdentity()->idUser;
                $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
                $user = $tableUtilisateur->find($idUser)->current();

                //$profils = $user->getProfils($this->_evenement->idOrga);
                $role = $user->getRole($this->_evenement->idOrga);
            }
        }
        
        //DEBUG : role=dev pour debugger
        //$role = 'dev';
        Zend_Registry::set('role',$role); //pour debugger avec ZFdebug
        
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        
        //$logger = Zend_Registry::get("cml_logger");
        $this->_logger->err('-');
        $this->_logger->err('entrée :');
        $this->_logger->err($controller.'/'.$action);
        $this->_logger->err('-');
        
        $front = Zend_Controller_Front::getInstance();
        $default = $front->getDefaultModule();

        // compose le nom de la ressource
        if ($module == $default) {
            $resource = $controller;
        } else {
            $resource = $module . '_' . $controller;
        }

        // est-ce que la ressource existe ?
        if (!$this->_acl->has($resource)) {
            $resource = null;
        }
        
 
//$role='visiteur';
        // contrôle si l'utilisateur est autorisé
        $this->_logger->err('isAllowed ? '.$role.','.$resource.','.$action);
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
            // l'utilisateur n'est pas autorisé à accéder à cette ressource
            // on va le rediriger
            if (!$this->_auth->hasIdentity()) {
                // il n'est pas identifié -> module de login
                //TODO : à tester :
                //  on passe un tableau contenant $module / $controller / $action / $params = $request->getParams()
                //  dans le registre. Ainsi il sera possible de récupérer ses informations pour rediriger

//                
//                $bulleNamespace = new Zend_Session_Namespace('bulle');
//                $bulleNamespace->retour = array('controller'=>$controller,'action'=>$action,'module'=>$module,'params'=>$request->getParams());
//                
//                $this->_logger = Zend_Registry::get("cml_logger");
//                $this->_logger->err('retour en session');
//                $this->_logger->err($controller.'/'.$action);
//                $this->_  logger->err('-');

                $module = self::FAIL_AUTH_MODULE;
                $controller = self::FAIL_AUTH_CONTROLLER;
                $action = self::FAIL_AUTH_ACTION;
            } else {
                // il est identifié -> error de privilèges
                $module = self::FAIL_ACL_MODULE;
                $controller = self::FAIL_ACL_CONTROLLER;
                $action = self::FAIL_ACL_ACTION;
            }
        }
        

        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
    }

}
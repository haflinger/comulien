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
        //récupération de l'évènement dans le registre (positionné par le plugin EvenementPlugin)
        $this->_logger->err('---DEBUT DE PLUGIN ACL--------------------------------------');
        if(Zend_Registry::isRegistered('checkedInEvent')){
            $this->_evenement = Zend_Registry::get('checkedInEvent');
        }
        
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        //
        //récupération du rôle de l'utilisateur
        //
        
        $role = 'visiteur'; //par défaut
        //si l'utilisateur en cours est connecté
        if ($this->_auth->hasIdentity()) {
            // nous avons à faire à un utilisateur connecté ! 
            // il sera donc AU MOINS utilisateur
            $role = 'utilisateur'; 
            //peut être a t'il un rôle plus important ?
            //on récupère l'utilisateur
            $idUser = $this->_auth->getIdentity()->idUser;
            $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
            $user = $tableUtilisateur->find($idUser)->current();
            
            //puis on va récupérer son rôle dans l'évènement
            if (!is_null($this->_evenement)) {
                $role = $user->getRole($this->_evenement->idOrga);
            }
            $this->_logger->err('L\'utilisateur '.$user->loginUser.' ('.$role.')');
        }else{
            $this->_logger->err('L\'utilisateur inconnu ('.$role.')');
        }
        //DEBUG : role=dev pour debugger
        //$role = 'dev';
        Zend_Registry::set('role',$role); //pour debugger avec ZFdebug
        
        $this->_logger->err('Demande l\'autorisation pour : '.$controller.'/'.$action);

        
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
            //return;
        }

        // contrôle si l'utilisateur est autorisé
        $this->_logger->err('isAllowed ? '.$role.','.$resource.','.$action);
        $this->_logger->err(' - '. ($this->_acl->isAllowed($role, $resource, $action))==true?"true":"false");
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
            // l'utilisateur n'est pas autorisé à accéder à cette ressource
            // on va le rediriger
            if (!$this->_auth->hasIdentity()) {
                $this->_logger->err('Il n\'a pas le droit et il n\'est pas connecté');
                $module = self::FAIL_AUTH_MODULE;
                $controller = self::FAIL_AUTH_CONTROLLER;
                $action = self::FAIL_AUTH_ACTION;
            } else {
                // il est identifié -> error de privilèges
                $this->_logger->err('Il n\'a pas le droit mais il est connecté');
                $module = self::FAIL_ACL_MODULE;
                $controller = self::FAIL_ACL_CONTROLLER;
                $action = self::FAIL_ACL_ACTION;
            }
        }

        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
        
        $this->_logger->err('Finalement l\utilisateur est redirigé sur : '.$controller.'/'.$action);
        $this->_logger->err('---FIN DE PLUGIN ACL--------------------------------------');
        
    }

}
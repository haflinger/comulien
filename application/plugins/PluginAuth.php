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
     * l'évènement en cours
     * @var rowset evenement 
     */
    private $_evenement = null;
    /**
     * Chemin de redirection lors de l'échec d'authentification
     */

    const FAIL_AUTH_MODULE = 'default';
    const FAIL_AUTH_ACTION = 'login';
    const FAIL_AUTH_CONTROLLER = 'login';

    /**
     * Chemin de redirection lors de l'échec de contrôle des privilèges
     */
    const FAIL_ACL_MODULE = 'default';
    const FAIL_ACL_ACTION = 'index';
    const FAIL_ACL_CONTROLLER = 'index';

    const FAIL_EVENT_MODULE = 'default';
    const FAIL_EVENT_ACTION = 'index';
    const FAIL_EVENT_CONTROLLER = 'index';
    /**
     * Constructeur
     */
    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
        $this->_auth = Zend_Auth::getInstance();
        
    }
    
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
    
    /**
     * Vérifie les autorisations
     * Utilise _request et _response hérités et injectés par le FC
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $this->getEvenement();

        if (is_null($this->_evenement)) {
//            $request->setModuleName(self::FAIL_EVENT_MODULE);
//            $request->setControllerName(self::FAIL_EVENT_CONTROLLER);
//            $request->setActionName(self::FAIL_EVENT_ACTION);
            $role = 'visiteur';
        }else {
            
        // is the user authenticated
        if ($this->_auth->hasIdentity()) {
            // yes ! we get his role
            $idUser = $this->_auth->getIdentity()->idUser;
            $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
            $user = $tableUtilisateur->find($idUser)->current();

            $profils = $user->getProfils($this->_evenement->idOrga);
            if ($profils->count()>0) {
                $role = 'identifie';
                //TODO : préciser s'il s'agit d'un corp ou orga
                //  (attention le cas ou l'utilisateur est à la fois corp ou orga)
            }
            else{
                $role = 'utilisateur';
            }
        } else {
            // no = guest user
            $role = 'visiteur';
        }
        }
        //DEBUG : role=dev pour debugger
        //$role = 'dev';
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

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

        // contrôle si l'utilisateur est autorisé
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
            // l'utilisateur n'est pas autorisé à accéder à cette ressource
            // on va le rediriger
            if (!$this->_auth->hasIdentity()) {
                // il n'est pas identifié -> module de login
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
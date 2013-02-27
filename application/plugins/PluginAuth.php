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

    /*
     * stocker la session
     */
    private $_session;

    /**
     * Chemin de redirection lors de l'échec d'authentification
     */

    const FAIL_AUTH_MODULE = 'default';
    const FAIL_AUTH_ACTION = 'authentifier';
    const FAIL_AUTH_CONTROLLER = 'utilisateur';
    const FAIL_AUTH_PARAMS = null;

    /**
     * Chemin de redirection lors de l'échec de contrôle des privilèges
     */
    const FAIL_ACL_MODULE = 'default';
    const FAIL_ACL_ACTION = 'index';
    const FAIL_ACL_CONTROLLER = 'index';
    const FAIL_ACL_PARAMS = null;

    /**
     * Constructeur
     */
    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
        $this->_auth = Zend_Auth::getInstance();
        $this->_logger = Zend_Registry::get("cml_logger");
        $this->_session = new Zend_Session_Namespace('bulle');
    }

    /**
     * Vérifie les autorisations
     * Utilise _request et _response hérités et injectés par le FC
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        //récupération de l'évènement dans le registre (positionné par le plugin EvenementPlugin)
        $this->_logger->err('---DEBUT DE PLUGIN ACL--------------------------------------');
        
        //chargement de l'évènement depuis le registre (évènement géré en amont par le plugin EvenementPlugin.php)
        if (Zend_Registry::isRegistered('checkedInEvent')) {
            $this->_evenement = Zend_Registry::get('checkedInEvent');
        }

        

        //récupération des module/controller/action/params pour la ressource actuellement demandée
        $reqModule      = $request->getModuleName();
        $reqController  = $request->getControllerName();
        $reqAction      = $request->getActionName();
        $reqParams      = $request->getParams();
        $this->_logger->err($reqModule.'/'.$reqController.'/'.$reqAction);
        if ($reqController=="utilisateur" && $reqAction=="index") {
            echo '';
        }
        $redirecting = false;
        if ($request->getParam('needRedirect',false)==true) {
            $redirParams = $this->_session->redirection;
            $reqModule = $redirParams["module"];
            $reqController = $redirParams["controller"];
            $reqAction = $redirParams['action'];
            $reqParams = $redirParams;
            $redirecting = true;
        }
        
        //préparation des paramètres de fin de routage
        $outModule      = $reqModule;
        $outController  = $reqController;
        $outAction      = $reqAction;
        $outParams      = $reqParams;
        
        //
        //récupération du rôle de l'utilisateur
        //
        $role = $this->getUserRole();

        //DEBUG : role=dev pour debugger
        //$role = 'dev';
        Zend_Registry::set('role', $role); //pour debugger avec ZFdebug

        $this->_logger->err('Demande l\'autorisation pour : ' . $reqController . '/' . $reqAction);


        $front = Zend_Controller_Front::getInstance();
        $default = $front->getDefaultModule();

        // compose le nom de la ressource
        if ($reqModule == $default) {
            $resource = $reqController;
        } else {
            $resource = $reqModule . '_' . $reqController;
        }

        
        // est-ce que la ressource demandée est soumise aux ACLs ?
        $this->_logger->err(" -> Demande de la ressource '" . $resource . "' ...");
        if (!$this->_acl->has($resource)) { //la ressource demandée n'est pas prévue dans les ACLs
            $this->_logger->err(" (la ressource '" . $resource . "' demandée n'existe pas dans les ACLs)");
            $resource = null;
            $reqAction = null;
            //return;
        }
        

        //Si l'utilisateur n'est pas authorisé à accéder à la ressource
        if ($this->_acl->has($resource) && !$this->_acl->isAllowed($role, $resource, $reqAction)) {
            $this->_logger->err(" - L'utilisateur n'est pas autorisé à accéder à la ressource");
            
            //si l'utilisateur n'a pas de session
            if (!$this->_auth->hasIdentity()) {
                $this->_logger->err(" - L'utilisateur n'est pas connecté");

                //on récupère en session les infos de redirection
               if (!isset($this->_session->redirection))  {
                   $this->_logger->err(" ==> sauvegarde dans le registre le NOUVEAU contenu de redirectinfos");
                    $this->_session->redirection = $reqParams;
                }
                
                // paramètres de route en cas d'utilisateur non connecté n'ayant pas le droit d'accès à la ressource
                $outModule      = self::FAIL_AUTH_MODULE;
                $outController  = self::FAIL_AUTH_CONTROLLER;
                $outAction      = self::FAIL_AUTH_ACTION;
                $outParams      = self::FAIL_AUTH_PARAMS;
                
            } else {
                // l'utilisateur actuel est connecté 
                $this->_logger->err(" - L'utilisateur est connecté");
                $outModule      = self::FAIL_ACL_MODULE;
                $outController  = self::FAIL_ACL_CONTROLLER;
                $outAction      = self::FAIL_ACL_ACTION;
                $outParams      = self::FAIL_ACL_PARAMS;
            }
            
        } 
        else //l'utilisateur a le droit d'accéder à la ressource
            { 
            
            $this->_logger->err(" - L'utilisateur peut tranquillement accéder à la ressource");
            
            //si l'utilisateur n'est pas connecté
            if (!$this->_auth->hasIdentity()) {
                
            } else {
                //l'utilisateur actuel est connecté
                
            }
        }
        
        
        //si le plugin devait effectuer la redirection
        if ($redirecting) {
             unset($this->_session->redirection);
             //$request->setParam('needRedirect', false);
             $outParams["needRedirect"]=false;
             //unset($outParams["needRedirect"]);
             $request->setPost($outParams);
             $_SERVER['REQUEST_METHOD']='POST';
             
        }
        
        //configure la requête pour la suite à donner
        $request->setModuleName($outModule);
        $request->setControllerName($outController);
        $request->setActionName($outAction);
        
        if (!is_null($outParams)) //gère le cas des params à null
        { 
            $request->clearParams();
            $request->setParams($outParams);
            
        }

        
        $this->_logger->err('Finalement l\utilisateur est redirigé sur : ' . $outController . '/' . $outAction);
        $this->_logger->err('---FIN DE PLUGIN ACL--------------------------------------');
    }

    private function getUserRole() {
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
                //$role = $user->getRole($this->_evenement->idOrga);
                $role = $user->getRole($this->_evenement->idOrga);
            }


            $this->_logger->err('L\'utilisateur ' . $user->loginUser . ' (' . $role . ')');
        } else {
            $this->_logger->err('L\'utilisateur inconnu (' . $role . ')');
        }
        return $role;
    }

}
<?php
//Zend_Session::start();
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    //TODO : voir pour récupérer l'évènement dans la session
    //      si la session n'a pas d'évènement le bootstrap pourrait rediriger vers une page spécifique
    //      Cette vérification sera commune à bon nombre de pages
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        $view->addHelperPath(APPLICATION_PATH . '/views/helpers');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
    }
    
    /**
     * initialisation de la journalisation
     */
    protected function _initLogging()
    {
        $logger = new Zend_Log();
        // récupérer et filtrer sur le niveau de log
        $optionLevel = (int) $this->_options["logging"]["level"];
        $filter = new Zend_Log_Filter_Priority($optionLevel);
        $logger->addFilter($filter);
        // ajouter un rédacteur qui écrit dans le fichier défini
        $optionPath = $this->_options["logging"]["filename"];
        $writer = new Zend_Log_Writer_Stream($optionPath);
        $logger->addWriter($writer);
        Zend_Registry::set("cml_logger", $logger);
    }
    
     protected function _initAcl()
    {
        // plugin Acl/Auth
        $acl_ini = APPLICATION_PATH . '/configs/acl.ini' ;
        $acl     = new Application_Plugin_AclIni($acl_ini);
        Zend_Controller_Front::getInstance()->registerPlugin(new Application_Plugin_PluginAuth($acl));
        Zend_Registry::set('Zend_Acl', $acl);
    }
}


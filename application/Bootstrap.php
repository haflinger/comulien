<?php
//Zend_Session::start();
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    //TODO : voir pour récupérer l'évènement dans la session
    //      si la session n'a pas d'évènement le bootstrap pourrait rediriger vers une page spécifique
    //      Cette vérification sera commune à bon nombre de pages
    protected function _initDoctype()
    {
        Zend_Session::start();
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        $view->addHelperPath(APPLICATION_PATH . '/views/helpers');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
    }
    
}


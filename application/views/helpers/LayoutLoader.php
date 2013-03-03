<?php
class Application_View_Helper_LayoutLoader
extends Zend_Controller_Action_Helper_Abstract 
{
    public function preDispatch() 
{
        $bootstrap = $this->getActionController()
                          ->getInvokeArg('bootstrap');
        $config = $bootstrap->getOptions();
        $module = $this->getRequest()->getModuleName();
        $format = $this->getRequest()->getParam('format');
        if (is_null($format)) {

            if (isset($config[$module]['resources']['layout']['layout'])) {
                $layoutScript =   
                       $config[$module]['resources']['layout']['layout'];
                $this->getActionController()
                     ->getHelper('layout')
                     ->setLayout($layoutScript);
            }
        }
        
    }
}
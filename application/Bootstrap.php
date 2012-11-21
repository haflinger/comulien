<?php


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public function run() {
        // Cela permet d'avoir le fichier de configuration disponible depuis n'importe ou dans l'application.
        Zend_Registry::set('config', new Zend_Config($this->getOptions()));
        parent::run();
    }

    public function _initTranslator() {

        $translator = new Zend_Translate(
                        array(
                            'adapter' => 'array',
                            'content' => APPLICATION_PATH . '/resources/languages', // chemin vers les fichiers
                            'locale' => 'fr',
                            'scan' => Zend_Translate::LOCALE_DIRECTORY
                        )
        );

        Zend_Validate_Abstract::setDefaultTranslator($translator);
    }

    protected function _initDoctype() {

        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->setEncoding('UTF-8');
        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
    }

}


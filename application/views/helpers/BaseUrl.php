<?php
//http://g-rossolini.developpez.com/tutoriels/php/zend-framework/debuter/?page=vue#LIV-C
class Zend_View_Helper_BaseUrl
{
    /**
     * Permet de récupérer l'URL de base du controller
     * @return string la baseUrl provenant d'une instance du controller
     */
    function baseUrl()
    {
        $fc = Zend_Controller_Front::getInstance();
        return $fc->getBaseUrl();
    }
    /*
     * Utilisation dans le layout par exemple :
     <link rel="stylesheet" type="text/css" media="screen"
       href="<?php echo $this->baseUrl();?>/public/css/site.css" />
     */
}
?>

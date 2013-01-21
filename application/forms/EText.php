<?php

/**
 * Description of EText
 * Créer un contrôle de formulaire en étendant Zend_Form_Element_Text
 * @author alexsolex
 */
class Application_Form_EText extends Zend_Form_Element_Text {
 
  public function __construct($options = null){
      parent::__construct($options);
      $this->setRequired(true)
      ->addFilter('StripTags')
      ->addFilter('StringTrim');
  }
}

?>

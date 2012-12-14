<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EText
 *
 * @author alexsolex
 */
class Application_Form_EText extends Zend_Form_Element_Text {
 
  public function __construct($label, $options = null){
          parent::__construct($options);
          $this->setLabel($label)
      ->setRequired(true)
      ->addFilter('StripTags')
      ->addFilter('StringTrim');
  }
}

?>

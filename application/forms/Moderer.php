<?php

class Application_Form_Moderer extends Twitter_Form //Zend_Form
{

    private $idMessage;

    public function init()
    {
        
    }
    
    public function setIdMessage($idMessage){
        $this->idMessage = $idMessage;
    }
    
    public function genererForm(){
        $hiddenIdMessage = new Zend_Form_Element_Hidden('hiddenIdMessage');
        $hiddenIdMessage->setValue($this->idMessage);
            
        $this->setAction('moderer')->setMethod('post');
        $this->setName ( 'moderer_message_'.$this->idMessage);
        
        $submit = new Zend_Form_Element_Submit ( 'submit'.$this->idMessage );
        $submit->setAttrib ( 'id', 'submitbutton'.$this->idMessage )->setLabel ( 'moderer'.$this->idMessage );

        $elements = array ($hiddenIdMessage, $submit );
        $this->addElements ( $elements );
        
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'forms/inscrireUtilisateur.phtml'))
        ));
    }
   

}


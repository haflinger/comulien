<?php

/**
 * Description of QrcodeController
 *
 * @author AlexSolex
 */
class QrcodeController extends Zend_Controller_Action
{
//    public $code_params = array('text'            => 'http://www.google.com', 
//                                'backgroundColor' => '#FFFFFF', 
//                                'foreColor' => '#000000', 
//                                'padding' => 4,  //array(10,5,10,5),
//                                'moduleSize' => 8);
//    
    
    public function testAction ()
    {
        $this->_helper->layout()->disableLayout();
    }
    
    public function embeddedImageAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->getRequest()->getParam('id',  null );
        
        $urlToEncode = 'http://localhost' . $this->_helper->url('checkin','evenement','default',array('id'=>$id));
        //$urlToEncode = $myhelper-> ;// . Zend_View_Helper_Url::url($urlArray);
        //$urlToEncode = "http://www.google.com/?q=".$id;
        $code_params = array(
            'text'            => $urlToEncode,
            'backgroundColor' => '#FFFFFF', 
            'foreColor'       => '#000000', 
            'padding'         => 4,//array(10,5,10,5),  
            'moduleSize'      => 6);
        // Zend_View_Helper_Url::url($urlArray);
        //$renderer_params = array('imageType' => 'jpg');
        $renderer_params = array('imageType' => 'png');
        Zend_Matrixcode::render('qrcode', $code_params, 'image', $renderer_params);
        //Zend_Matrixcode::render('qrcode', $code_params, 'svg');
    }
    
    public function embeddedSvgAction ()
    {
        $code_params = array(
            'text'            => "http://www.google.fr",
            'backgroundColor' => '#FFFFFF', 
            'foreColor'       => '#000000', 
            'padding'         => 4,//array(10,5,10,5),  
            'moduleSize'      => 6);
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        Zend_Matrixcode::render('qrcode', $code_params, 'svg');
    }
    
    public function downloadAction ()
    {
        $code_params = array(
            'text'            => "http://www.google.fr",
            'backgroundColor' => '#FFFFFF', 
            'foreColor'       => '#000000', 
            'padding'         => 4,//array(10,5,10,5),  
            'moduleSize'      => 6);
        $type = $extension = $this->getRequest()->getParam('type', 'image');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if ($type == 'image') {
            $renderer_params['imageType'] = 'png';
            $extension = 'png';
        } else if ($type == 'pdf') {
            $renderer_params['footnote'] = 'QR code demo';
        }
        $renderer_params['sendResult'] = array('Content-Disposition: attachment;filename="qrcode-demo.' . $extension . '"');
        Zend_Matrixcode::render('qrcode', $code_params, $type, $renderer_params);
    }
    
    public function saveImageAction ()
    {
        $code_params = array(
            'text'            => "http://www.google.fr",
            'backgroundColor' => '#FFFFFF', 
            'foreColor'       => '#000000', 
            'padding'         => 4,//array(10,5,10,5),  
            'moduleSize'      => 6);
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $renderer_params = array('imageType' => 'png', 'sendResult' => false);
        
        $res = Zend_Matrixcode::render('qrcode', $code_params, 'image', $renderer_params);
        imagepng($res, realpath(APPLICATION_PATH . '/../public/tmp') . DIRECTORY_SEPARATOR . 'qrcode_test.png');
    }
}
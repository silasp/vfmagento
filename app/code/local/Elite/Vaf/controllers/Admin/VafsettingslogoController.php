<?php
class Elite_Vaf_Admin_VafsettingslogoController extends Mage_Adminhtml_Controller_Action
{ 
    function indexAction()
    {
        //$this->checkVersion();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/import');
        
        $this->myIndexAction();
        
        $block = $this->getLayout()
                ->createBlock('core/template', 'vafsettings/logo' )
                ->setTemplate('vafsettings/logo.phtml');
        
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function myIndexAction()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $form = new Elite_Vaf_Model_Settings_Logo;
            $form->populate($_POST);
            
            $config = $form->getConfig();
            foreach($form->getElements() as $name=>$element)
            {
                if($name=='save') continue;
                $config->logo->$name = $element->getValue();
            }
            
            $writer = new Zend_Config_Writer_Ini(array('config'   => $config,
                                                    'filename' => ELITE_CONFIG));
            echo $writer->write();
        }
    }
    
    
  
}
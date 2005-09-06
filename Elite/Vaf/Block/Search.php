<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class Elite_Vaf_Block_Search extends Elite_Vaf_Block_Abstract implements VF_Configurable
{
    protected $search;
    
    function __construct()
    {
        $this->search = new VF_Search_Mage;
    }
    
    function __call($name, $arguments)
    {
        return call_user_func_array(array($this->search,$name), $arguments);
    }
    
    function getFilter()
    {
        if( !$this->filter instanceof Elite_Vaf_Model_Catalog_Category_Filter )
        {
            $this->filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl();
            $this->filter->setConfig( $this->getConfig() );
        }    
        return $this->filter;
    }
    
    function setFilter( Elite_Vaf_Model_Catalog_Category_Filter $filter )
    {
        $this->filter = $filter;
    }
    
    function url( $route )
    {
        return Mage::getUrl( $route );
    }
    
    function _toHtml()
    {
        if( !$this->shouldShow( $this->currentCategoryId() ) )
        {
            return '';
        }
        $html = $this->renderView();
        return $html;
    }
}

class VF_Search_Mage extends VF_Search
{
    /** @var array of category ids we are searching */
    protected $categories;
    
    /** @var Elite_Vaf_Block_Search_CategoryChooser */
    protected $chooser;
    
    /** @var Elite_Vaf_Model_Catalog_Category_Filter */
    protected $filter;
    
    function __construct()
    {
         $this->categories = ( isset( $_GET['category'] ) && is_array( $_GET['category'] ) ) ? $_GET['category'] : array( 3 );
         foreach( $this->categories as $index => $id )
         {
             $this->categories[ $index ] = (int)$id; // allow integers only
         }
         $this->chooser = new Elite_Vaf_Block_Search_CategoryChooser();
    }
    
    function translate()
    {
        $args = func_get_args();
        return Elite_Vaf_Helper_Data::getInstance()->__( $args[0] );
    }
}
<?php
class Elite_Vafsitemap_Model_Sitemap_VehicleTests_DefinitionMMTCTest extends Elite_Vaf_TestCase
{
    protected $make, $model, $trim, $chassis;
    
    function doSetUp()
    {
        $this->switchSchema( 'make,model,trim,chassis' );
    }

    function testDefinitions()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle(Elite_Vaf_Helper_Data::getInstance()->getConfig());
        $vehicle = $this->createMMTC();
        $this->insertMappingMMTC( $vehicle );

        $vehicles = $sitemap->getDefinitions();
        $this->assertTrue( $vehicles[0] instanceof VF_Vehicle );
        $this->assertNotEquals( 0, (int)$vehicles[0]->getLevel('chassis')->getId() );
    }

}
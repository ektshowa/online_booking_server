<?php
namespace Tests\Models;

require_once "/var/www/html/mailinglistmanager.local/mailinglist/Helpers/application_constants.php";
require_once DOCTRINE_BOOTSTRAP_FOLDER . DOCTRINE_BOOTSTRAP_FILENAME;
require_once MODELS_FOLDER . SUBSCRIBER_MODELMAPPER_FILENAME;
require_once HELPERS_FOLDER . ORM_OBJECT_FILENAME;
require_once MODELS_FOLDER . ROLE_MODEL_FILENAME;

use ProjectORM\DoctrineBootstrap;
use Models\SubscriberModelMapper;

class SubscriberModelMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testEntityManagerCall()
    {
        $mock = $this->getMockBuilder('SetOrmObject')
                     ->setMethods(array('getDoctrineEntityManager'))
                     ->getMock();
                     
        $mock->expects($this->once())
             ->method('getDoctrineEntityManager');
             
        $subscriber = array("firstname" => "angy1",
                        "lastname" => "bebebe1",
                        "password" => "angy1",
                        "addressline1" => "7_Eureka_ave",
                        "email" => "angy1@gmail.com",
                        "role" => "regular");
             
        $mock::getDoctrineEntityManager();
    }
}

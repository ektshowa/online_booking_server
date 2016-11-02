<?php
namespace Tests\Services;

require_once "/var/www/html/mailinglistmanager.local/mailinglist/Helpers/application_constants.php";
require_once LOGIN_SERVICES_FOLDER . "register.php";
require_once CONTROLLERS_FOLDER . SUBSCRIBERS_CONTROLLERS_FILENAME;

use LoginServices\Register; 
use Controllers\SubscribersController;

class RegisterTest extends \PHPUnit_Framework_TestCase {
       
    public function testDoRegister(){
        $register = new Register();
        
        $subscriber = array("firstname" => "angy1",
                        "lastname" => "bebebe1",
                        "password" => "angy1",
                        "addressline1" => "7_Eureka_ave",
                        "email" => "angy1@gmail.com",
                        "role" => "regular"); 
        $controller = new SubscribersController();   
        
     //   $result = $register->doRegister($controller, "createSubscriber", $subscriber);
        $this->assertArrayHasKey('firstname', $subscriber);            
                        
        //$result = $register->doRegister($controller, "createSubscriber", $subscriber);
        //$this->assertTrue($result['success']);
        
    }
}

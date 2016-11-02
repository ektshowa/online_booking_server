<?php

namespace LoginServices;

require_once ABSTRACT_LOGIN_SERVICES_FOLDER . "abstractRegister.php";
require_once MODELS_FOLDER . "subscriberModel.php";

use AbstractLoginServices\AbstractRegister;
use Models\SubscriberModel;

class Register extends AbstractRegister {
	protected $subscriberModel;
/*
 * Following Zend create a bootstrap class that will create a database connection object
 * the boostrap will have a run method that is executed. The run method will instantiate the database connection.
 * Boostrap will be called in the index file. 
 */	
	public function doRegister ($controller, $action, array $subscriber) {
		    
		//trigger_error("IN REGISTER SERVICES " . $action); 
       // error_log(print_r($subscriber, TRUE));
        	
		$result = $controller->$action($subscriber);
        
        //trigger_error("OUT OF REGISTER SERVICE");
        //error_log($result);	
		
		return $result;
    }
}
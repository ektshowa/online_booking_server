<?php
namespace LoginServices;

require_once ABSTRACT_LOGIN_SERVICES_FOLDER . "abstractRegister.php";
require_once ABSTRACT_VALIDATIONS_FOLDER . "abstractRegisterValidations.php";
require_once VALIDATIONS_FOLDER . "registerValidations.php";
require_once LOGIN_SERVICES_FOLDER . "register.php";
require_once SERVICES_CONTROLLERS_ACTIONS_MAPPER_PATH . "serviceControllerActionMapper.php";

use AbstractLoginServices\AbstractRegister;
use AbstractValidations\AbstractRegisterValidations;
use Validations\RegisterValidations;
use LoginServices\Register;

class RegisterProxy {
	
	protected $validations;
	
    protected function setEmail($email){
		$this->email = htmlentities($email);
	}
	protected function setFirstname($firstname){
		$this->firstname = htmlentities($firstname);
	}
	protected function setLastname($lastname){
        $this->lastname = htmlentities($lastname);
	}
    protected function setRole($role){
    	$this->role = htmlentities($role);
    }
	protected function setMimetype($mimetype){
		$this->mimetype = htmlentities($mimetype);
	}
	protected function setPassword($password){
		$this->password = htmlentities($password);
	}
	protected function setAddressline1($addressline1){
		$this->addressline1 = htmlentities($addressline1);
	}
	
	// Parameter Associative array of subscriber from the Form Client
	protected function getSubscriber(array $subscriber) {
	  $result = array();
	  
	  $result['firstname'] = $this->setFirstname($subscriber['firstname']);
	  $result['lastname'] = $this->setLastname($subscriber['lastname']);
	  $result['email'] = $this->setEmail($subscriber['email']);
	  $result['role'] = $this->setRole($subscriber['role']);
	  $result['password'] = $this->setPassword($subscriber['password']);
	  $result['addressline1'] = $this->setPassword($subscriber['addressline1']);
	  
	  /*The mimetype will be used later for email marketing only
	  $result['mimetype'] = $this->setMimetype($subscriber['mimetype']);
	   */
	  
	  return $result;
	}
	// Set the local Validate class 
	protected function setValidate(AbstractRegisterValidation $validations){
        // Add a try catch to throw exception when subscriber array is null	
        // Use Composition to instantiate the Registration  
        $this->validations = new RegisterValidations($this->subscriber);	
	}
    
    public function getController() {
        try {
            require_once LOGIN_SERVICES_CONTROLLER_FILEPATH . LOGIN_SERVICES_CONTROLLER_FILENAME;
        }
        catch (\Exception $e) {
            trigger_error("REGISTER PROXY - GET SERVICES: " . $e->getMessage());
        }
        $serviceController = constant("LOGIN_SERVICES_CONTROLLER_CLASSNAME");
        return new $serviceController();
    }
    public function getAction() {
        return constant("LOGIN_SERVICES_SUBSCRIBER_CONTROLLER_REGISTER_ACTION");
    }   
    
	// Do validations with the Registervalidations class
	// If validations successfull, do the registration 
	// This should be changed. The $requestParams parameter should be removed.
	public function doRegister(array $subscriber){
		// Validate the register fields
		$this->validations = new RegisterValidations($this->getSubscriber($subscriber));
		$validationResult = $this->validations->doValidate();
        $controller = $this->getController();
        $action = $this->getAction();
	
	    // If the validation is a success do registration
		if (!$validationResult['success']) {
				
			$result['message'] = $validationResult['message']; 
            
            //trigger_error("VALIDATION RESULT");
            //error_log(print_r($validationResult, TRUE));	
			
			foreach ($validationResult as $key => $value) {
				//Check if some fields did not pass the validation.
				//If there is at least one, set the success key to FALSE.
				if ($key != "notSetRequiredFields") {
					if (!$value['isValid']) {
						$result['success'] = FALSE;
						$result['message'] .= "Some fields validation did not succeed";
						break;
					}
				}
			}
			$result['success'] = FALSE;
		}
		// return the validation result
        else {
            // Call the registration class to do the registration
		    $register = new Register();
		    $result = $register->doRegister($controller, $action, $subscriber);
			
        }	
	    return $result;	
		
	}
	
	
		
		
}
        

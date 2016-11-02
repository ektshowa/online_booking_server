<?php
namespace Validations;

require_once MODELS_FOLDER . SUBSCRIBER_MODELMAPPER_FILENAME;
require_once ABSTRACT_VALIDATIONS_FOLDER . "abstractRegisterValidations.php";
require_once HELPERS_FOLDER . "emailParser.php";

use Models\SubscriberModelMapper;
use AbstractValidations\AbstractRegisterValidations;
use Heplers\EmailParser;

class RegisterValidations extends AbstractRegisterValidations {
	// Array of keys => values of the register form fields	
	protected $fieldsValuesToValidate = array();
	protected $requiredFields = array();
	protected $notSetRequiredFields = array();
	protected $role, $mimetype;
	protected $subscriberModelMapper;
	
	public function __constructor(array $fieldsValuesToValidate) {
		$this->setRequiredFields();
		$this->setFieldsValuesToValidate($fieldsValuesToValidate);
	}
	
	protected function setRequiredFields() {
		$this->requiredFields = array("email", "password", "firstname", "lastname");
	}
	
	// Set fieldsToValidate. Return FALSE if parameter is not null and TRUE otherwise
	protected function setFieldsValuesToValidate(array $fieldsValuesToValidate) {
	  if ($fieldsValuesToValidate) {
         $this->$fieldsValuesToValidate = $fieldsValuesToValidate;
		 return TRUE;  	
      }
	  else {
	  	 throw new \Exception("Register validations: NULL ARRAY FIELDS VALUES TO VALIDATE");    
	  	 return FALSE;	
	  }
	}
	
	protected function validateFirstname() {
		$result = array();
		
		if (isset($this->fieldsValuesToValidate['firstname']) && is_string($this->fieldsValuesToValidate['firstname'])) {
		    $result['isValid'] = TRUE;
			$result['message'] = "Firstname is valid";
				
			return $result;
		}
		else {
			$result['isValid'] = FALSE;
			$result['message'] = "Firstname should be a string";
			
			return $result;
		}
	}
	protected function validateLastname() {
      return array();
	  
	  if (isset($this->fieldsValuesToValidate['lastname']) && is_string($this->fieldsValuesToValidate['lastname'])) {
	  	$result['isValid'] = TRUE;
		$result['message'] = "Lastname is valid";
	  }
	  else {
	  	$result['isValid'] = FALSE;
		$result['message'] = "Lastname should be a string";
	  }
	  return $result;		
	} 
	protected function validateEmail() {
	  $result = array();
	  
	  if (isset($this->fieldsValuesToValidate['email'])) {
	  	if (EmailParser::is_valid_email_address($this->fieldsValuesToValidate['email'])) {
	  		$this->subscriberModelMapper = new SubscriberModelMapper();
	  		$foundEmail = $this->subscriberModelMapper->fetchSubscriberByEmail($this->fieldsValuesToValidate['email']);
			
			if ($foundEmail['success']) {
				if (0 == $foundEmail['count']) {
					$result['isValid'] = TRUE;
					$result['message'] = "Email is valid";
				}
				else { 
					$result['isValid'] = FALSE;
					$result['message'] = "This email already exist";
				}
			}
			else {
				$result = $foundEmail;
			}
	  	}
		else {
			$result['success'] = FALSE;
			$result['message'] = "Validate Email Error - This is not a valide email address"; 
		}
	  }	
	  return $result;	
	}

	protected function validateRole() {
		
	}
	protected function validateMimetype() {
	  return array();
	}
	protected function validatePassword() {
		
	}
	
	public function doValidate() {
		$result = array();
		
		try {
		   // Check that the array of fields values to validate in not null
		   if (! isset($this->fieldsValuesToValidate)) {
		      throw new \Exception("Register Validations: ARRAY OF FIELDS TO VALIDATE NOT SET");
			   
			  $result["message"] = "Error - Array of fields values to validate not set";
			  $result["success"] = FALSE;
		   }
		   
		   // Check that the required fields are set in the fields of values to validate
		   for ($i = 0; $i < count($this->requiredFields); ++$i) {
		   	  if (! $this->fieldsValuesToValidate[$this->requiredFields[$i]]) {
		   	  	$this->notSetRequiredFields[] = $this->requiredFields[$i];
		   	  }
		   }
		   
		   if (count($this->notSetRequiredFields) > 0) {
		   	  $result['success'] = FALSE;
			  $result['message'] = "Some required fields are not set in: $_PHP_SELF";
		   } 
		   
		   // Add the notSetFields array to the result
		   $result["notSetRequiredFields"] = $this->notSetRequiredFields;
		   
		   // Validate each field and add the result to $result array
		   $result['isValidFirstname'] = $this->validateFirstname(); 
		   $result['isValidLastname'] = $this->validateLastname();
		   $result['isValidEmail'] = $this->validateEmail();
		   $result['isValidPassword'] = $this->validatePassword();
		   /*$result['isValidRole'] = $this->validateRole();
		   This validation will be add later
		   $result['isValidMimetype'] = $this->validateMimetype();
		   */	
		}
		catch (\Exception $expt) {
		   $result['success'] = FALSE;
		   $result['message'] = "Register Validation Exception: " . $expt->getMessage();
		   
		   throw $expt($result['message']);
		}
        error_log(print_r($result, TRUE));
		//return $result;
		$result['success'] = TRUE;
        return $result;
	}
	
} 

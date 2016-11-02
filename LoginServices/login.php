<?php

namespace LoginServices;

require_once ABSTRACT_LOGIN_SERVICES_FOLDER . "abstractLogin.php";
use AbstractLoginServices\AbstractLogin;

class Login extends AbstractLogin {
	protected $controllerData;
	protected $action;
	protected $credentials;
	
	public function __contructor() {
		//$this->controllerData = $controllerData;
		//$this->action = $action;
		//$this->credentials = $credentials;
	}
	
	// With Login credentials call the controller->action in this function
	public function doLogin($controller, $action, array $credentials) {
		trigger_error("IN LOGINSERVICES " . $action);	
		error_log(print_r($credentials, TRUE));
			
		// $credentials are username and password keys
		//--------------------------
		//$action = "loginSubscriber";
		//--------------------------
		$result = $controller->$action($credentials);
		
		trigger_error("OUT OF LOGIN SERVICE");
		
		return $result;
	}
	
}

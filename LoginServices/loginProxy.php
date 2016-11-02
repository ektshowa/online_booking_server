<?php
namespace LoginServices;

require_once ABSTRACT_LOGIN_SERVICES_FOLDER . "abstractProxyLogin.php";
require_once LOGIN_SERVICES_FOLDER . "login.php";
require_once SERVICES_CONTROLLERS_ACTIONS_MAPPER_PATH . "serviceControllerActionMapper.php";

use AbstractLoginServices\AbstractProxyLogin;
use LoginServices\Login;


class LoginProxy extends AbstractProxyLogin {

    protected $controllerClass;
	protected $actionMethod;
	protected $requestParams;
    protected $controller;
	
	public function __constructor() {
		trigger_error("IN LOGIN PROXY SERVICES");
        
        
        $this->controllerAction = constant("loginSubscriber");
	}
    public function getController() {
        try {
            require_once LOGIN_SERVICES_CONTROLLER_FILEPATH . LOGIN_SERVICES_CONTROLLER_FILENAME;
        }
        catch (\Exception $e) {
            trigger_error("LOGIN PROXY - GET SERVICES: " . $e->getMessage());
        }
        $serviceController = constant("LOGIN_SERVICES_CONTROLLER_CLASSNAME");
        return new $serviceController();
    }
    public function getAction() {
        return constant("LOGIN_SERVICES_SUBSCRIBER_CONTROLLER_LOGIN_ACTION");
    }	
	public function doLogin(array $requestBody) {
			trigger_error("IN LOGIN PROXY SERVICES");
            $controller = $this->getController();
            $action = $this->getAction(); 
            	
			// Extract the credentials from the request parameters to pass them 
			// separately to the login method
			$credentials = array('email' => $requestBody['email'], 'password' => $requestBody['password']);
			$loginService = new Login();
			
			// Add to this function the login credentials
			$result = $loginService->doLogin($controller, $action, $credentials);
			
			trigger_error($result);
			return $result;
		}
	
}

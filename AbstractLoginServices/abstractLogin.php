<?php

namespace AbstractLoginServices;

abstract class AbstractLogin {
	
	//protected $username, $password, $igor, $goodLog, $badLog;
	//protected $security = array();
	//protected $passSecurity = FALSE;
	//protected abstract function loginOrDie();
	public abstract function doLogin($controllerData, $action, array $requestBody);
	
	//protected function setPassword();
}

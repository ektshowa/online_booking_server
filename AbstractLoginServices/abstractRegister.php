<?php
namespace AbstractLoginServices;

abstract class AbstractRegister {
	
	abstract function doRegister($controller, $action, array $subscriber);
}

<?php

namespace AbstractLoginServices;

abstract class AbstractProxyLogin {
    
    //protected $username, $password, $igor, $goodLog, $badLog;
    //protected $security = array();
    //protected $passSecurity = FALSE;
    //protected abstract function loginOrDie();
    public abstract function doLogin(array $requestBody);
    
    //protected function setPassword();
}

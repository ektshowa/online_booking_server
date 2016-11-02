<?php 
require '../vendor/autoload.php';

require_once LOGIN_SERVICES_FOLDER . "loginProxy.php";
require_once LOGIN_SERVICES_FOLDER . "registerProxy.php";
 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use LoginServices\LoginProxy;
use LoginServices\RegisterProxy;

$app = new \Slim\App;

$app->post('/login-subscriber', function($request, $response, $args) {
      $parsedBody = $request->getParsedBody();
      $parsedBody = array_keys($parsedBody);
      $requestBody = json_decode($parsedBody[0], TRUE);
      
      $service = new LoginProxy();
      $result = $service->doLogin($requestBody);
      
      trigger_error("SERVICE RESULT ");
      error_log(print_r($result, TRUE));
      
      //RETURN THE RESULTS INSTEAD OF THE DATA. CAST THE RESULT IN JSON
      // AS DATA
      $data = json_encode($result);
      $resp = $response->withAddedHeader('Access-Control-Allow-Origin', 'http://mailinglistclient.local');
      $body = $resp->getBody();
      
      $newResponse = $resp->withJson($data);
      return $newResponse;
 });
 
 $app->post('/register-subscriber', function (Request $request, Response $response, $args) {
    $parsedBody = $request->getParsedBody();
    $parsedBody = array_keys($parsedBody);
    $requestBody = json_decode($parsedBody[0], TRUE);
    trigger_error("-----REGISTER REQUEST BOBY-----");
    error_log(print_r($requestBody, TRUE));
    $service = new RegisterProxy();
    $result = $service->doRegister($requestBody);
    
    trigger_error("REGISTER SERVICE RESULT");
    error_log(print_r($result, TRUE));
    $data = json_encode($result);
    $resp = $response->withAddedHeader('Access-Control-Allow-Origin', 'http://mailinglistclient.local');
    $body = $resp->getBody();
    
    $newResponse = $resp->withJson($data);
    return $newResponse;
});
 
  
/*
$app->post('/', function ($request, $response, $args) {
    
    trigger_error("SLIM INDEX GET IN THE CONTROLLER");
    
    // Query parameters should include service and action
    // For example request for subscriber login will include service=login&action=read
    $requestParams = $request->getQueryParams();
    $parsedBody = $request->getParsedBody();
    
    $parsedBody = array_keys($parsedBody);
    $requestBody = json_decode($parsedBody[0], TRUE);
    
    error_log(print_r($requestBody, TRUE));
    trigger_error("PARSEDBODY LENGHT " . count(array_keys($requestBody)));
    //trigger_error('SUBSCRIBER_CONTROLLER ' . SUBSCRIBERS_CONTROLLER);
    
    //CREATE AN XML FILE THAT WILL STORE ALL INFORMATION ABOUT CONTROLLERS
    //ELEMENT CONTROLLER; ATTRIBUTES: CONTROLLER NAME ...
    //CHILD ELEMENTS: FILE NAME; FILE PATH; ACTIONS
    //CHILD ELEMENTS FOR ACTIONS: READ, CREATE, DELETE, UPDATE
    
    // Load the XML controller mapper
    //$xmlControllerMapper = simplexml_load_file(SERVICES_CONTROLLER_ACTION_MAPPER_FILE);
    
    $xmlMappingFileFullPath = HELPERS_FOLDER . SERVICES_CONTROLLER_ACTION_MAPPER_FILE;
    $xmlControllerMapper = new XMLUtilityFunctions($xmlMappingFileFullPath);
    
    //trigger_error("MAPPING FILENAME " . $xmlMappingFileFullPath);
    /*
    #################
    if ($requestParams['action'] === 'subscriberlogin') {
            
            // Read the XML file and get controller folder and filename - replace the values here
            // Get the controller and the action - replace the values here
            
            include_once CONTROLLERS_FOLDER . SUBSCRIBERS_CONTROLLERS_FILENAME;
            
            $subscribersController = SUBSCRIBERS_CONTROLLER;
            $subscribersController = new $subscribersController($requestParams);
            $method = "readAction"; 
            $responseFromController = $subscribersController->$method();
            //error_log(print_r($request->getHeaders(), TRUE));
            $newResponse = $response->withAddedHeader('Access-Control-Allow-Origin', 'http://mailinglistclient.local');
            //$newResponse_1 = $newResponse->withAddedHeader('Content-Type', 'application/json');
            //return json_encode($response);
            $body = $newResponse->getBody();
            $body->write($responseFromController);
            return $newResponse;
        } ##############
    
    $serviceControllerData = $xmlControllerMapper->getControllerData($requestParams['service']);
    $controllerAction = $xmlControllerMapper->getActionName($requestParams['service']);
    
    //trigger_error("CONTROLLER TYPE " . gettype($serviceControllerData));
    //error_log(print_r($serviceControllerData, TRUE));
    
    //Call the service here. I supposed that the service controller data has been mofify to include
    //the key "service" => "servicename";
    $service = $serviceControllerData['serviceData']['className'];
    $serviceMethod = $serviceControllerData['serviceData']['serviceMethod'];
    
    
    
    // Get the controller data that will be passed to the service method
    $controllerData = $serviceControllerData['controllerData'];
    
    // The service should inherit from the interface. The interface has 
    // one method, the one whose the name is in the XML. That method should have two 
    // parameters. Array and string 
    
    $serviceClass = new $service();
    
    //$serviceClass = new LoginServices\LoginProxy($controllerData, $controllerAction, $requestParams);
    
    //trigger_error("SERVICE CLASS NAME" . get_class($serviceClass));
    
    
    $serviceResult = $serviceClass->$serviceMethod($controllerData, $controllerAction, $requestParams, $requestBody);
    
    trigger_error("SERVICE RESULT ");
    error_log(print_r($serviceResult, TRUE));
    
    $resp = $response->withAddedHeader('Access-Control-Allow-Origin', 'http://mailinglistclient.local');
    $body = $resp->getBody();
    
    //$body->write($serviceResult);
    trigger_error("-----AFTER ---- BODY-------");
    $data = array('name' => 'Bob', 'age' => 40);
    $newResponse = $resp->withJson($data);
    
    return $newResponse;
});
*/

$app->get('/login-test/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, subscriber $name");

    return $response;
});

  
 
/*
$app->get('/', function (Request $request, Response $response) {
    //$name = $request->getAttribute('name');
    //$response->getBody()->write("Hello, $name");
    
    $response->getBody()->write("Hello, teggy");
    return $response;
});*/

$app->run();
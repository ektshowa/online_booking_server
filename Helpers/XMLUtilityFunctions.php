<?php

namespace Helpers;

/**
 * Set of function for parsing the XML controller action
 */

class XMLUtilityFunctions {
	
	protected $xmlfilename;
	protected $reader;
	protected $simpleXML;
	
	public function __construct($xmlfilename){
		$this->xmlfilename = $xmlfilename;
        trigger_error("XMLUTILITYFUNCTION CONSTRUCTOR");
	}
	
	public function setReader() {
		$this->reader = new \XMLReader();
		$this->reader->open($this->xmlfilename);
	}
	
	public function setSimpleXML() {
		try {
		    $this->simpleXML = simplexml_load_file($this->xmlfilename);	
			return TRUE;
		}
		catch (\Exception $e) {
			trigger_error("ERROR - XMLUtilityFunction - Unable to load XML File");
			return FALSE;
		}
	}
	
	// Get the controller name, filename, and folder given the service parameter from the request
	// Using the XMLReader parser. The parameter should be equal to the service node ID. 
	// Return an associative array. 
	// !!! ADD THE CONTROLLER NAMESPACE IN THE XML MAPPER FILE
	public function getControllerData($serviceNodeID) {
		if (! is_string($serviceNodeID)) {
			throw new \Exception("The Service Node ID should be a string");
		}
		
		$this->setReader();
		$controllerData = array();
		$serviceData = array();
		
		while ($this->reader->read()) {
			// If you find the controller node with ID equal $controllerParam
			if ($this->reader->nodeType == \XMLReader::ELEMENT && 
			    $this->reader->localName == 'service') {
			    	$this->reader->moveToAttribute('id');
                    
                    /* This have already been implemented but check it during debuging
					 * 
					 * 
					 * As it is this will not work. At this point I got the service id attribute
					 * I should add the attribute classname to the service node.
					 * Because I am in the service node, I should move to the next element, if it 
					 * is not a controller, continue. The else block can stay as is.
					 * IN THE RETURNED ARRAY ADD THE SERVICE CLASSNAME
					 */ 
					
					//Modify this later to use moveToNextAttribute(), reader->localname, reader->value
					
					trigger_error('IN XML SERVICE NODE ONE ' . $this->reader->value);
					
					if ($this->reader->value == $serviceNodeID) { 
					    trigger_error('IN XML SERVICE NODE TWO' . $this->reader->value);
						    $this->reader->moveToAttribute('className');
						    $serviceData['className'] = $this->reader->value;
						    $this->reader->moveToAttribute('serviceMethod');
						    $serviceData['serviceMethod'] = $this->reader->value;
					}
                    else {
                        $this->reader->next();
                    }
			}
			// After getting the service data get in the controller node to 
			// Gather controller data	
			else if ($this->reader->nodeType == \XMLReader::ELEMENT && 
			         $this->reader->localName == 'controller') {
			             
                         trigger_error("IN XML UTILITY");
			         	
						$this->reader->moveToAttribute('name');
						$controllerData['name'] = $this->reader->value;
						$this->reader->moveToAttribute('referer');
						$controllerData['referer'] = $this->reader->value;
						$this->reader->moveToAttribute('folderID');
						$controllerData['folderID'] = $this->reader->value;
						$this->reader->moveToAttribute('filenameID');
						$controllerData['filenameID'] = $this->reader->value;
						
						// Exit the loop here, the controller id is unique
						break;
			}
		}
		return array('serviceData' => $serviceData, 'controllerData' => $controllerData);	
	}

    // Get the action name in the controller for the provided request parameters
    public function getActionName($serviceNodeID) {
    	
		//ADD HERE A TRY CACTH AND MODIFY THE RESULT RETURNED
    	if (! is_string($serviceNodeID)) {
    		throw new \Exception("The ServiceNodeID parameter should be a string");
    	}
		
    	$this->setSimpleXML();
		$xpathParam = "/services/service[@id='" . $serviceNodeID . "']/controller/action";
		
		if ($this->simpleXML) {
		    $action = $this->simpleXML->xpath($xpathParam);
			$result = $action[0]->attributes();
			
		    //array_keys($result));
		    //error_log(print_r($result['id'], TRUE));
		    $stringResult = $result['id'];
            
		trigger_error("IN XML GET ACTION " . $stringResult->__toString());
          	
		return $stringResult->__toString();	
		}
		else {
			return FALSE;
            
		}
    }
}

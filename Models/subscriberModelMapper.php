<?php
namespace Models;

//require_once DOCTRINE_BOOTSTRAP_FOLDER . DOCTRINE_BOOTSTRAP_FILENAME;
require_once ABSTRACT_MODELS_FOLDER . ABSTRACT_SUBSCRIBER_MODEL_FILENAME;
require_once MODELS_FOLDER . SUBSCRIBER_MODEL_FILENAME;
require_once ABSTRACT_MODELS_FOLDER . ABSTRACT_SUBSCRIBER_MODELMAPPER_FILENAME;
require_once MODELS_FOLDER . ROLE_MODEL_FILENAME;


use AbstractModels\AbstractSubscriberModelMapper;
use AbstractModels\AbstractSubscriberModel;
use Helpers\SetOrmObject;
//use SubscriberModel; 
//use ProjectORM\DoctrineBootstrap;

//
class SubscriberModelMapper extends AbstractSubscriberModelMapper {
	
	protected $subscriberModel;
	protected $inputParams;
	protected $entityManager;    
    
	public function __construct() {
		//ADD A TRY CATCH HERE
		$this->setEntityManager();
	}
	protected function setSetFecthSubscriberMessage($message, $functionName, $fieldName) {
		return ($message)? $message : "Model SubscriberModelMapper - $functionName $fieldName is not set";
	}
    
    public function setEntityManager() {
        $this->entityManager = SetOrmObject::getDoctrineEntityManager(); 
    }
		
	public function setSubscriberModel(AbstractSubscriberModel $subscriberModel) {
		$this->subscriberModel = $subscriberModel;
	}
	
	public function fetchUser($id){
		$subscriberModel = $entityManager->find('SubscriberModel', $id);
	}
	
	public function fetchSubscriberByEmail($email) {
		$result = array();
		
		if (!empty($email) && is_string($email)){
			try {
				$query = $this->entityManager->createQuery('SELECT COUNT(s.email) FROM Models\SubscriberModel s');
				$count = $query->getSingleScalarResult();	
				$result['count'] = $count;
				$result['success'] = TRUE; 
			}
			catch (\Exception $e) {
				trigger_error("Models - SubscriberModelMapper - fecthSubscriberByEmail EXCEPTION " . $e->getMessage());
				$result['success'] = FALSE;
				$result['message'] = "Error while searching Subscriber Email";
			}
		}
		else {
			$result['success'] = FALSE;
			$result['message'] = "Error: Email should be a String";
		}
		return $result;
	}
	
	/*
	 * This function get two string parameters, the user's credentials: email and password. 
	 * It retruns an array with keys:
	 *    - if not found: success => FALSE and message => Subscriber not found 
	 *    - if more than one found: success => FALSE, message => more than one found, data => found ids
	 *    - if one found: success => TRUE, data => subscriber attributes
	 */
	public function fetchSubscriberByCredentials($email, $password) {
		if (!is_string($email)) {
			throw new \Exception("Models - SubscriberModelMapper - fetchSubscriberByCredentials: The parameter email should be a string");
		}
		if (!is_string($password)) {
			throw new \Exception("Models - SubscriberModelMapper - fetchSubscriberByCredentials: No Password provided");
		}
		$result = array();
		
		try {
	          //$model = $this->entityManager->find('Models\SubscriberModel', "admin@localhost");
	          $query = $this->entityManager->createQuery('SELECT partial s.{id, firstname, lastname, email, addressline1} ' . 
	                                                     'FROM Models\SubscriberModel s ' .
	                                                     'WHERE s.email = :emailParam AND s.password = :passParam');
			 
			  
			 
			 
			  $query->setParameters(array(
			          'emailParam' => $email,
				      'passParam' =>  $password
			  ));
			  $subscriber = $query->getResult();
			 
			  /*
			   * THIS IS ANOTHER WAY TO QUERY THE SUBSCRIBER. TO USE THE DOCTRINE API
			   *
			  $dql = 'SELECT s.firstname, s.lastname, s.email, s.addressline1, s.city, s.state, s.zip ' .
	                 'FROM Models\SubscriberModel s'  . 
	                 'WHERE s.email = ?1 AND s.password = ?2 ';
			  
			  $subscriber = $this->entityManager->createQuery($dql)
			                                    ->setParameters(array(
			                                          1 => $email,
				                                      2 => $password
			                                       ))
			                                    ->getResult();	
												
			  									  
		      */
		
		      //IF MORE THAN ONE RETURN RESULT FALSE WITH MESSAGE
		      //CONCATENATE THE MESSAGES RETURNED BY THE GETS FOR THE MISSING DATA
		      if ($subscriber === null) {
		          $result['success'] = FALSE;
			      $result['message'] = "No subscriber found for given credentials";
		      } 
			  elseif (count($subscriber) > 1) {
			  	  $result['success'] = FALSE;
				  $result['message'] = "More than one subscribers found for this email address - $email";
				  
				  for ($i = 0; $i < count($subscriber); $i++) {
				  	$result['data'][$i] = $subscriber[$i]->getId();
				  }
			  }
		      elseif ((count($subscriber) == 1) and ($subscriber[0] instanceof AbstractSubscriberModel)) {
		      	 //Concatenate messages from all the get method to return them in the function result
		      	 $fullMessage = '';
				 $listOfFields = array('firstname', 'lastname', 'email', 'password', 'addressline1', 'addressline2', 
				                        'roleid', 'createdDate', 'updatedDate');
										
				 for ($i = 0; $i < count($listOfFields); ++ $i) {
				 	//Create get function names
				 	$getFunction = 'get' . ucfirst($listOfFields[$i]);
					$temp = $subscriber[0]->$getFunction();
					
					if ($temp['success'] and !empty($temp['data'])) {
						$result['data'][$listOfFields[$i]] = $temp['data'];
					}
					else {
						$fullMessage .= $this->setSetFecthSubscriberMessage($temp['message'], 'fetchSubscriberByEmail', $listOfFields[$i]);
					}
				 }
				 trigger_error("SUBSCRIBER GET FUNCTS ". $fullMessage);
				 $result['success'] = TRUE;
                 $result['message'] = $fullMessage;
                 error_log(print_r($result, TRUE));
			}
		}
		catch (\Exception $e) {
			trigger_error("IN SUBSCRIBER MAPPER fecthSubscriberByEmail EXCEPTION " . $e->getMessage());
		}
		error_log(print_r($result, TRUE));
		return $result;
	}

    public function addUser($user) {
		if (!is_array($user)) {
			throw new \Exception("Models - SubscriberModelMapper - addUser: The parameter should be the Subscriber array");
		}
		$result = array();
		$this->subscriberModel = new SubscriberModel();
        $this->subscriberModel->setFirstname($user['firstname']);
        $this->subscriberModel->setLastname($user['lastname']);
        $this->subscriberModel->setEmail($user['email']);
        $this->subscriberModel->setAddressline1($user['addressline1']);
        $this->subscriberModel->setPassword($user['password']);
        
        //CHANGE THE QUERY FROM SQL TO DQL
        $query = $this->entityManager->createQuery("select partial r.{id, role, description} " .
                                                   "from Models\RoleModel r " . 
                                                    "where r.role = :roleCode");
        $query->setParameters(array(
                      'roleCode' => $user['role']
                     ));
        $role = $query->getResult();
        
      //  trigger_error("PRINTING SET ROLE ID");
        
     //   error_log(print_r($role[0]->getId(), true));
        
        // I will have to initialize a new role object with the query result
        // and use it as paramater to setRole
        $this->subscriberModel->setRole($role[0]);
        
		try {
			$this->entityManager->persist($this->subscriberModel);
			$this->entityManager->flush();
			$result['success'] = TRUE;
			$result['id'] = $this->subscriberModel->getId();
		}
		catch (\Exception $e) {
			trigger_error("MODELS - SUBSCRIBERMAPPER - ADDUSER: " . $e->getMessage());
			$result['success'] = FALSE;
			$result['message'] = "Failed to insert new Subscriber";
		}
		return $result;
	}
	
	public function removeUser($user) {
		
	}
	public function updateUser($user){}
	
	public function fetchAllUsers($params) {}
	
	public function fetchSomeUsers($params) {}
	
}

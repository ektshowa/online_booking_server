<?php
//Database Constantes
define("DATABASE_ADMIN_USERNAME", "root");
define("DATABASE_ADMIN_PASSWORD", "admin");

//Controllers Constantes
define("ABSTRACT_CONTROLLERS_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/AbstractControllers/");
define("CONTROLLERS_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/Controllers/");
define("SUBSCRIBERS_CONTROLLER" , "Controllers\\SubscribersController");
define("SUBSCRIBERS_CONTROLLERS_FILENAME", "subscribersController.php");
define("SERVICES_CONTROLLERS_ACTIONS_MAPPER_PATH", "/var/www/html/mailinglistmanager.local/mailinglist/Helpers/");

//Models Constantes
define("ABSTRACT_MODELS_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/AbstractModels/");
define("MODELS_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/Models/");
define("ABSTRACT_SUBSCRIBER_MODEL_FILENAME", "abstractSubscriberModel.php");
define("ABSTRACT_SUBSCRIBER_MODELMAPPER_FILENAME", "abstractSubscriberModelMapper.php");
define("SUBSCRIBER_MODEL_FILENAME", "subscriberModel.php");
define("ROLE_MODEL_FILENAME", "roleModel.php");
define("SUBSCRIBER_MODELMAPPER_FILENAME", "subscriberModelMapper.php");
define("ABSTRACT_VALIDATIONS_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/AbstractValidations/");
define("VALIDATIONS_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/Validations/");
define("DOCTRINE_BOOTSTRAP_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/ProjectORM/");
define("DOCTRINE_BOOTSTRAP_FILENAME", "doctrineBootstrap.php");
define("ORM_OBJECT_FILENAME", "setOrmObject.php");

//Login Services Constantes
define("ABSTRACT_LOGIN_SERVICES_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/AbstractLoginServices/");
define("LOGIN_SERVICES_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/LoginServices/");
define("LOGINPROXY_SERVICES_CLASS", "LoginServices\\LoginProxy");
define("REGISTERPROXY_SERVICES_CLASS", "LoginServices\\RegisterProxy");

//Helpers Constantes
define("HELPERS_FOLDER", "/var/www/html/mailinglistmanager.local/mailinglist/Helpers/");
define("SERVICES_CONTROLLER_ACTION_MAPPER_FILE","servicesControllerActionMapper.xml");


<?php

namespace Helpers;

require_once DOCTRINE_BOOTSTRAP_FOLDER . DOCTRINE_BOOTSTRAP_FILENAME;

use ProjectORM\DoctrineBootstrap;

class SetOrmObject {

    protected static $entityManager = NULL;
    //protected $doctrineBootstrap;
    
    public function __construct() {
        //ADD A TRY CATCH HERE
    }
    
    public static function getDoctrineEntityManager() {
        if (NULL == self::$entityManager) {
            $doctrineBootstrap = new DoctrineBootstrap();
            self::$entityManager = $doctrineBootstrap->getEntityManager();
            return self::$entityManager; 
        }
        return self::$entityManager; 
    }
        
}

    
<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
require_once dirname(__FILE__)."/vendor/autoload.php";

include_once dirname(__FILE__)."/src/Product.php";
include_once dirname(__FILE__)."/src/Category.php";
include_once dirname(__FILE__)."/src/Novedades.php";
include_once dirname(__FILE__)."/src/Ticket.php";
include_once dirname(__FILE__)."/src/Perfil.php";
include_once dirname(__FILE__)."/src/__CG__Product.php";
include_once dirname(__FILE__)."/src/__CG__Category.php";
include_once dirname(__FILE__)."/src/__CG__Novedades.php";
include_once dirname(__FILE__)."/src/__CG__Perfil.php";
include_once dirname(__FILE__)."/src/__CG__Ticket.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'host' => 'mysql.nixiweb.com',
    'user' => 'u897309850_skate',
    'password'=> 'republic12&22',
    'dbname' => 'u897309850_skate'
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
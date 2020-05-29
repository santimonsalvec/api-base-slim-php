<?php

date_default_timezone_set("America/Bogota");

//header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, PATCH, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

use Controller\UserController;
use Controller\HospitalsController;
use Controller\LocationsController;
use Firebase\JWT\JWT;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../vendor/autoload.php';
require_once '../environments/environments.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = new \Slim\App;

$appConfig = array(
    'ignore' => [],
    'secret' => $jwt_secret,
    'secure' => false,
    'displayErrorDetails' => true
);

$app->add(new Tuupola\Middleware\JwtAuthentication($appConfig));

$app->group('/users', function() use ($app){
    require 'Controllers/Users/UserController.php';
});

// Run app
$app->run();
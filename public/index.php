<?php 

require __DIR__ . '/../vendor/autoload.php';
use MoView\App\Router;
use MoView\Controller\HomeController;
use \MoView\Config\Database;
use MoView\Controller\UserController;

//set database to app production
Database::getConnection("prod");

//router
Router::add("GET","/",HomeController::class,"index",[]);
Router::add("GET","/users/register",UserController::class,"register",[]);
Router::add("POST","/users/register",UserController::class,"postRegister",[]);

//router run
Router::run();
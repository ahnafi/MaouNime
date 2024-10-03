<?php 

require __DIR__ . '/../vendor/autoload.php';
use MoView\App\Router;
use MoView\Controller\HomeController;
use \MoView\Config\Database;
use MoView\Controller\UserController;

//set database to app production
Database::getConnection("prod");

//router home
Router::add("GET","/",HomeController::class,"index",[]);
Router::add("GET","/comment",HomeController::class,"comment",[]);

//router user
Router::add("GET","/users/register",UserController::class,"register",[]);
Router::add("POST","/users/register",UserController::class,"postRegister",[]);
Router::add("GET","/users/login",UserController::class,"login",[]);
Router::add("POST","/users/login",UserController::class,"postLogin",[]);
Router::add("GET","/users/logout",UserController::class,"logout",[]);


//router run
Router::run();
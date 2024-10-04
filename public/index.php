<?php 

require __DIR__ . '/../vendor/autoload.php';
use MoView\App\Router;
use MoView\Controller\HomeController;
use \MoView\Config\Database;
use MoView\Controller\UserController;
use MoView\Middleware\MustLoginMiddleware;
use MoView\Middleware\MustNotLoginMiddleware;

//set database to app production
Database::getConnection("prod");

//router home
Router::add("GET","/",HomeController::class,"index",[]);
Router::add("GET","/comment",HomeController::class,"comment",[mustLoginMiddleware::class]);

//router user
Router::add("GET","/users/register",UserController::class,"register",[MustNotLoginMiddleware::class]);
Router::add("POST","/users/register",UserController::class,"postRegister",[MUstNotLoginMiddleware::class]);
Router::add("GET","/users/login",UserController::class,"login",[mustNotLoginMiddleware::class]);
Router::add("POST","/users/login",UserController::class,"postLogin",[mustNotLoginMiddleware::class]);
Router::add("GET","/users/logout",UserController::class,"logout",[mustLoginMiddleware::class]);


//router run
Router::run();
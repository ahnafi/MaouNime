<?php 

require __DIR__ . '/../vendor/autoload.php';
use MoView\App\Router;
use MoView\Controller\HomeController;
use MoView\Config\Database;
use MoView\Controller\UserController;
use MoView\Middleware\MustLoginMiddleware;
use MoView\Middleware\MustNotLoginMiddleware;

//set database to app production
Database::getConnection("prod");

//set timezone
date_default_timezone_set("Asia/jakarta");

//router home
Router::add("GET","/",HomeController::class,"index");
Router::add("GET","/anime",HomeController::class,"anime");
Router::add("GET","/anime/detail/([0-9]*)",HomeController::class,"detailAnime");
Router::add("GET","/anime/search",HomeController::class,"searchAnime");
Router::add("POST", "/anime/comment", HomeController::class, "postComment", [MustLoginMiddleware::class]);
Router::add("POST","/anime/watchlist",HomeController::class,"postWatchlist",[MustLoginMiddleware::class]);

//router user
Router::add("GET","/users/profile",UserController::class,"userProfile",[MustLoginMiddleware::class]);
Router::add("GET","/users/register",UserController::class,"register",[MustNotLoginMiddleware::class]);
Router::add("GET","/users/login",UserController::class,"login",[MustNotLoginMiddleware::class]);
Router::add("GET","/users/logout",UserController::class,"logout",[MustLoginMiddleware::class]);
Router::add("GET","/users/update",UserController::class,"updateProfile",[mustLoginMiddleware::class]);
Router::add("GET","/users/password",UserController::class,"updatePassword",[mustLoginMiddleware::class]);
Router::add("POST","/users/login",UserController::class,"postLogin",[MustNotLoginMiddleware::class]);
Router::add("POST","/users/register",UserController::class,"postRegister",[MustNotLoginMiddleware::class]);
Router::add("POST","/users/update",UserController::class,"postUpdateProfile",[mustLoginMiddleware::class]);
Router::add("POST","/users/password",UserController::class,"postUpdatePassword",[mustLoginMiddleware::class]);
Router::add("POST","/users/watchlist/update",UserController::class,"postWatchlistUpdate",[MustLoginMiddleware::class]);
Router::add("POST","/users/watchlist/delete",UserController::class,"postWatchlistDelete",[MustLoginMiddleware::class]);

//error
Router::add("GET","/error",HomeController::class,"error404");

//router run
Router::run();
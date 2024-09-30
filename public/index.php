<?php 

require_once __DIR__ . "/../app/App/Router.php";

Router::add("GET","/","HomeController@index","");
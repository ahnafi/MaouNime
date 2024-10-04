<?php

namespace MoView\Controller;
use MoView\App\View;
use MoView\Config\Database;
use MoView\Repository\SessionRepository;
use MoView\Repository\UserRepository;
use MoView\Service\SessionService;

class HomeController
{
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function index():void
    {
        $user = $this->sessionService->current();
        if($user == null) {
            View::render('Home/index', [
                "title" => "PHP Login Management"
            ]);
        }else {
            View::render("Home/dashboard", [
            "title" => "Home",
                "user" => [
                    "name"=> $user->name,
                ]
            ]);
        }
    }

    public function comment():void{
        $user = $this->sessionService->current();
            View::render("Home/comment", [
                "title" => "comment anime",
                "user" => $user->name,
                "anime" => "anime naruto",
            ]);
    }
}
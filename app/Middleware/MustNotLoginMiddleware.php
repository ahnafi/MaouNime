<?php

namespace MoView\Middleware;

use MoView\App\View;
use MoView\Config\Database;
use MoView\Repository\SessionRepository;
use MoView\Repository\UserRepository;
use MoView\Service\SessionService;

class MustNotLoginMiddleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user != null) {
            View::redirect('/');
        }
    }
}
<?php

namespace MoView\Controller;

use MoView\App\View;
use MoView\Config\Database;
use MoView\Exception\ValidationException;
use MoView\Model\UserDeleteWatchlistRequest;
use MoView\Model\UserLoginRequest;
use MoView\Model\UserPasswordUpdateRequest;
use MoView\Model\UserProfileUpdateRequest;
use MoView\Model\UserProfileWatchlistRequest;
use MoView\Model\UserRegisterRequest;
use MoView\Model\UserUpdateWatchlistRequest;
use MoView\Repository\AnimeRepository;
use MoView\Repository\SessionRepository;
use MoView\Repository\UserRepository;
use MoView\Repository\WatchListRepository;
use MoView\Service\SessionService;
use MoView\Service\UserService;
use MoView\Service\WatchListService;

class UserController
{
    private UserService $userService;
    private SessionService $sessionService;
    private WatchListService $watchListService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);

        $animeRepository = new AnimeRepository($connection);
        $watchListRepository = new WatchListRepository($connection);
        $this->watchListService = new WatchListService($watchListRepository,$animeRepository,$userRepository);
    }

    public function register(): void
    {
        View::render('User/register', [
            'title' => 'Register new user',
        ]);
    }

    public function postRegister(): void
    {
        $request = new UserRegisterRequest();
        $request->id = $_POST['id'];
        $request->name = $_POST['name'];
        $request->password = $_POST['password'];

        try {
            $this->userService->register($request);
            View::redirect('/users/login');
        } catch (ValidationException $exception) {
            View::render("/User/register", [
                'title' => 'Register new user',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function login(): void
    {
        View::render('User/login', [
            'title' => 'Login',
        ]);
    }

    public function postLogin(): void
    {
        $request = new UserLoginRequest();
        $request->id = $_POST['id'];
        $request->password = $_POST['password'];
        $redirectUrl = $_GET['redirect'] ?? '/';
        try {
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->id);
            View::redirect($redirectUrl);
        } catch (ValidationException $exception) {
            View::render("/User/login", [
                'title' => 'Login',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function logout(): void
    {
        $this->sessionService->destroy();
        View::redirect('/');
    }

    public function updateProfile(): void
    {
        $user = $this->sessionService->current();
        View::render("User/update", [
            'title' => 'Update profile',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ]
        ]);
    }

    public function postUpdateProfile(): void
    {
        $user = $this->sessionService->current();

        $request = new UserProfileUpdateRequest();
        $request->id = $user->id;
        $request->name = $_POST['name'];

        try {
            $this->userService->updateProfile($request);
            View::redirect('/');
        } catch (ValidationException $exception) {
            View::render("User/update", [
                'title' => 'Update profile',
                'error' => $exception->getMessage(),
                'user' => [
                    'id' => $user->id,
                    'name' => $_POST['name'],
                ]
            ]);
        }
    }

    public function updatePassword()
    {
        $user = $this->sessionService->current();
        View::render("User/password", [
            'title' => 'Update password',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ]
        ]);
    }
    public function postUpdatePassword(): void
    {
        $user = $this->sessionService->current();
        $request = new UserPasswordUpdateRequest();
        $request->id = $user->id;
        $request->newPassword = $_POST['newPassword'];
        $request->oldPassword = $_POST['oldPassword'];

        try {
            $this->userService->updatePassword($request);
            View::redirect('/');
        } catch (ValidationException $exception) {
            View::render("User/password", [
                'title' => 'Update password',
                'error' => $exception->getMessage(),
                'user' => [
                    'id' => $user->id,
                ]
            ]);
        }
    }

    public function userProfile(): void
    {
        $user = $this->sessionService->current();
        $userId = new UserProfileWatchlistRequest();
        $userId->userId = $user->id;
        $response = $this->watchListService->fetchUserWatchlist($userId);

        $data = [
            'title' => 'User profile',
            'user' => [
                'name' => $user->name,
            ]
        ];

        if(isset($response->watchList))
        {
            $data["watchlist"] = $response->watchList;
        }

        View::render("User/profile", $data);
    }

    public function postWatchlistUpdate(): void
    {
        $user = $this->sessionService->current();
        $request = new UserUpdateWatchlistRequest();
        $request->watchListId = (int) $_POST['watchListId'];
        $request->userId = $user->id;
        $request->animeId = (int) $_POST['animeId'];
        $request->status = $_POST['status'];

        try {
            $this->watchListService->updateWatchList($request);
            View::redirect('/users/profile');
        } catch (ValidationException $exception) {

            // unhandle error

            View::redirect('/users/profile');
        }
    }

    public function postWatchlistDelete(): void
    {
        $user = $this->sessionService->current();
        $animeId = (int) htmlspecialchars($_POST['animeId']);

        try {

            $request = new UserDeleteWatchlistRequest();
            $request->userId = $user->id;
            $request->animeId = $animeId;

            $this->watchListService->deleteWatchList($request);
            View::redirect('/users/profile');
        } catch (ValidationException $exception) {

            // unhandle error

            View::redirect('/users/profile');
        }
    }
}
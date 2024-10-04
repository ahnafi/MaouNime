<?php

namespace MoView\Controller;

use MoView\App\View;
use MoView\Config\Database;
use MoView\Exception\ValidationException;
use MoView\Model\UserLoginRequest;
use MoView\Model\UserProfileUpdateRequest;
use MoView\Model\UserRegisterRequest;
use MoView\Repository\SessionRepository;
use MoView\Repository\UserRepository;
use MoView\Service\SessionService;
use MoView\Service\UserService;

class UserController
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct(){
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository,$userRepository);
    }

    public function register():void {
        View::render('User/register',[
            'title' => 'Register new user',
        ]);
    }

    public function postRegister():void {
        $request = new UserRegisterRequest();
        $request->id = $_POST['id'];
        $request->name = $_POST['name'];
        $request->password = $_POST['password'];

        try{
            $this->userService->register($request);
            View::redirect('/users/login');
        }catch (ValidationException $exception){
            View::render("/User/register",[
                'title' => 'Register new user',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function login():void{
        View::render('User/login',[
            'title' => 'Login',
        ]);
    }

    public function postLogin():void{
        $request = new UserLoginRequest();
        $request->id = $_POST['id'];
        $request->password = $_POST['password'];
        try{
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->id);
            View::redirect('/');
        }catch (ValidationException $exception){
            View::render("/User/login",[
                'title' => 'Login',
                'error' => $exception->getMessage()
            ]);
        }

    }

    public function logout():void {
        $this->sessionService->destroy();
        View::redirect('/');
    }

    public function updateProfile():void{
        $user = $this->sessionService->current();
        View::render("User/profile",[
            'title' => 'Update profile',
            'user'=> [
                'id' => $user->id,
                'name' => $user->name,
            ]
        ]);
    }

    public function postUpdateProfile():void{
        $user = $this->sessionService->current();

        $request = new UserProfileUpdateRequest();
        $request->id = $user->id;
        $request->name = $_POST['name'];

        try {
         $this->userService->updateProfile($request);
         View::redirect('/');
        } catch (ValidationException $exception){
            View::render("User/profile",[
                'title' => 'Update profile',
                'error' => $exception->getMessage(),
                'user'=> [
                    'id' => $user->id,
                    'name' => $_POST['name'],
                ]
            ]);
        }
    }
}
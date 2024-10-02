<?php

namespace MoView\Controller;

use MoView\App\View;
use MoView\Config\Database;
use MoView\Exception\ValidationException;
use MoView\Model\UserLoginRequest;
use MoView\Model\UserRegisterRequest;
use MoView\Repository\UserRepository;
use MoView\Service\UserService;

class UserController
{
    private UserService $userService;

    public function __construct(){
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);
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
            $this->userService->login($request);
            View::redirect('/');
        }catch (ValidationException $exception){
            View::render("/User/login",[
                'title' => 'Login',
                'error' => $exception->getMessage()
            ]);
        }

    }
}
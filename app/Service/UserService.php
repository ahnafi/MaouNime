<?php

namespace MoView\Service;

use MoView\Config\Database;
use MoView\Domain\User;
use MoView\Exception\ValidationException;
use MoView\Model\UserLoginRequest;
use MoView\Model\UserLoginResponse;
use MoView\Model\UserRegisterRequest;
use MoView\Model\UserRegisterResponse;
use MoView\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request):UserRegisterResponse {

        $this->validateUserRegistrationRequest($request);

        try{
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);

            if($user != null){
                throw new ValidationException('User already exists.');
            }

            $user = new User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->save($user);
            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();
            return $response;
        }catch (\Exception $err){
            Database::rollbackTransaction();
            throw $err;
        }
    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request):void {
        if($request->id == null || $request->name == null || $request->password == null ||
            trim($request->id) == "" || trim($request->password) == "" || trim($request->name) == ""
        ) {
            throw new ValidationException ("All fields are required");
        }
    }

    public function login(UserloginRequest $request):UserLoginResponse {
        $this->validateUserLoginRequest($request);

            $user = $this->userRepository->findById($request->id);

            if($user == null){
                throw new ValidationException('id or password is wrong');
            }

            if(password_verify($request->password, $user->password)){
                $response = new UserLoginResponse();
                $response->user = $user;
                return $response;
            }else {
                throw new ValidationException("id or password is wrong");
            }
    }

    private function validateUserLoginRequest(UserLoginRequest $request):void {
        if($request->id == null || $request->password == null ||
            trim($request->id) == "" || trim($request->password) == ""
        ) {
            throw new ValidationException ("id and password cannot be empty");
        }
    }

}
<?php

namespace MoView\Service;

use MoView\Config\Database;
use MoView\Domain\User;
use MoView\Exception\ValidationException;
use MoView\Model\UserLoginRequest;
use MoView\Model\UserLoginResponse;
use MoView\Model\UserPasswordUpdateRequest;
use MoView\Model\UserPasswordUpdateResponse;
use MoView\Model\UserProfileUpdateRequest;
use MoView\Model\UserProfileUpdateResponse;
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

    public function updateProfile(UserProfileUpdateRequest $request):UserProfileUpdateResponse {
        $this->validateUserProfileUpdateRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);

            if($user == null){
                throw new ValidationException ("user is not found");
            }

            $user->name = $request->name;
            $this->userRepository->update($user);

            Database::commitTransaction();

            $response = new UserProfileUpdateResponse();
            $response->user = $user;
            return $response;
        }catch (\Exception $err){
            Database::rollbackTransaction();
            throw $err;
        }
    }

    private function validateUserProfileUpdateRequest(UserProfileUpdateRequest $request):void {
        if($request->id == null || $request->name == null ||
            trim($request->id) == "" || trim($request->name) == ""
        ) {
            throw new ValidationException ("name cannot be empty");
        }
    }

    public function updatePassword(UserPasswordUpdateRequest $request):UserPasswordUpdateResponse {
        $this->validateUserPasswordUpdateRequest($request);

        try{
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);

            if($user == null){
                throw new ValidationException ("user is not found");
            }

            if (!password_verify($request->oldPassword,$user->password )) {
                throw new ValidationException ("old password is wrong");
            }

            if (password_verify($request->newPassword,$request->oldPassword )) {
                throw new ValidationException ("new password cannot be same as old password");
            }

            $user->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
            $this->userRepository->update($user);

            Database::commitTransaction();

            $response = new UserPasswordUpdateResponse();
            $response->user = $user;
            return $response;
        }catch (\Exception $err){
            Database::rollbackTransaction();
            throw $err;
        }
    }

    private function validateUserPasswordUpdateRequest(UserPasswordUpdateRequest $request):void {
        if($request->id == null || $request->newPassword == null || $request->oldPassword == null ||
            trim($request->id) == "" || trim($request->oldPassword) == "" || trim($request->newPassword) == ""
        ) {
            throw new ValidationException ("new password cannot be empty");
        }
    }

}
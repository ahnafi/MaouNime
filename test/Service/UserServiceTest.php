<?php

namespace MoView\Service;

use MoView\Config\Database;
use MoView\Domain\User;
use MoView\Exception\ValidationException;
use MoView\Model\UserLoginRequest;
use MoView\Model\UserPasswordUpdateRequest;
use MoView\Model\UserProfileUpdateRequest;
use MoView\Model\UserRegisterRequest;
use MoView\Repository\SessionRepository;
use MoView\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void {
        $connection = Database::getConnection();
        $this->sessionRepository = new SessionRepository($connection);
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);
        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess(){
        $request = new UserRegisterRequest();
        $request->id = "budi";
        $request->name = "budi";
        $request->password = "123456";

        $response = $this->userService->register($request);
        self::assertEquals($request->id, $response->user->id);
        self::assertEquals($request->name, $response->user->name);

        self::assertNotEquals($request->password, $response->user->password);
        self::assertTrue(password_verify($request->password, $response->user->password));
    }
    public function testRegisterFail(){
        $this->expectException(ValidationException::class);
        $request = new UserRegisterRequest();
        $request->id = "  ";
        $request->name = "  ";
        $request->password = "   ";

        $this->userService->register($request);
    }
    public function testRegisterDuplicate(){

        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = "123456";

        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "budi";
        $request->name = "budi";
        $request->password = "123456";

        $response = $this->userService->register($request);
    }

    public function testLoginSuccess(){
        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = password_hash("123456", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserLoginRequest();
        $request->id = "budi";
        $request->password = "123456";

        $result = $this->userService->login($request);
        self::assertEquals($request->id, $result->user->id);
        self::assertTrue(password_verify($request->password, $result->user->password));
    }
    public function testLoginWrongPassword(){
        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = password_hash("123456", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->id = "budi";
        $request->password = "12345677";

        $this->userService->login($request);
    }
    public function testLoginNotFound(){
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->id = "budi";
        $request->password = "123456";

        $this->userService->login($request);

    }

    public function testUpdateProfileSuccess (){
        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = password_hash("123456", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserProfileUpdateRequest();
        $request->id = "budi";
        $request->name = "budionosiregar";

        $this->userService->updateProfile($request);

        $response = $this->userRepository->findById($user->id);
        self::assertEquals($request->name, $response->name);
    }

    public function testUpdateProfileValidationError(){
        $this->expectException(ValidationException::class);

        $request = new UserProfileUpdateRequest();
        $request->id = "    v   ";
        $request->name = "       ";

        $this->userService->updateProfile($request);
    }

    public function testUpdateProfileNotFound(){
        self::expectException(ValidationException::class);
        $request = new UserProfileUpdateRequest();
        $request->id = "budi";
        $request->name = "budionosiregar";

        $this->userService->updateProfile($request);
    }

    public function testUpdatePasswordSuccess (){
        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = password_hash("123456", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserPasswordUpdateRequest();
        $request->id = "budi";
        $request->oldPassword = "123456";
        $request->newPassword = "55555";

        $this->userService->updatePassword($request);

        $response = $this->userRepository->findById($user->id);
        self::assertTrue(password_verify($request->newPassword,$response->password));
    }

    public function testUpdatePasswordNotEmpty():void{
        self::expectException(ValidationException::class);
        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = password_hash("123456", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserPasswordUpdateRequest();
        $request->id = "budi";
        $request->oldPassword = "123456";
        $request->newPassword = "";

        $this->userService->updatePassword($request);

        self::expectExceptionMessage("new password cannot be same as old password");
        $request->newPassword = "123456";
        $this->userService->updatePassword($request);

    }

    public function testUpdatePasswordWrongOldPassword(){
        self::expectException(ValidationException::class);
        self::expectExceptionMessage("old password is wrong");

        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = password_hash("123456", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserPasswordUpdateRequest();
        $request->id = "budi";
        $request->oldPassword = "abcs";
        $request->newPassword = "aaa";

        $this->userService->updatePassword($request);
    }

}

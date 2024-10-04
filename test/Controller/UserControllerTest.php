<?php

namespace MoView\Controller;

require_once __DIR__ . "/../Helper/helper.php";

use MoView\Config\Database;
use MoView\Domain\Session;
use MoView\Domain\User;
use MoView\Repository\SessionRepository;
use MoView\Repository\UserRepository;
use MoView\Service\SessionService;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{

        private UserController $userController;
        private UserRepository $userRepository;
        private SessionRepository $sessionRepository;

        public function setUp(): void
        {

            $this->userController = new UserController();

            $this->sessionRepository = new SessionRepository(Database::getConnection());
            $this->sessionRepository->deleteAll();

            $this->userRepository = new UserRepository(Database::getConnection());
            $this->userRepository->deleteAll();

            putenv("mode=test");
        }

        public function testRegister()
        {
            $this->userController->register();

            $this->expectOutputRegex('/Register new user/');
            $this->expectOutputRegex('<form>');
            $this->expectOutputRegex('[name="name"]');

        }

        public function testPostRegisterSuccess()
        {
            $_POST['id'] = "budi";
            $_POST['name'] = "budi";
            $_POST['password'] = "budi";

            $this->userController->postRegister();
            $this::expectOutputRegex('[Location: /users/login]');
        }

        public function testPostRegisterFail()
        {
            $_POST['id'] = "budi";
            $_POST['name'] = "budi";
            $_POST['password'] = "  ";

            $this->userController->postRegister();
            $this->expectOutputRegex('/Register new user/');
            $this->expectOutputRegex('<form>');
            $this->expectOutputRegex('[name="name"]');
            $this->expectOutputRegex('[All fields are required]');
        }

        public function testPostRegisterDuplicate()
        {
            $user = new User();
            $user->name = "budi";
            $user->password = password_hash("budi", PASSWORD_BCRYPT);
            $user->id = "budi";

            $this->userRepository->save($user);

            $_POST['id'] = "budi";
            $_POST['name'] = "budi";
            $_POST['password'] = "budi";

            $this->userController->postRegister();
            $this->expectOutputRegex('/Register new user/');
            $this->expectOutputRegex('<form>');
            $this->expectOutputRegex('[name="name"]');
            $this->expectOutputRegex('[User already exists.]');
        }

        public function testLogin(){
            $this->userController->login();

            $this->expectOutputRegex('/login/');
            $this->expectOutputRegex('<form>');
            $this->expectOutputRegex('[name="id"]');
            $this->expectOutputRegex('[name="password"]');

        }

        public function testPostLoginSuccess(){
            $user = new User();
            $user->name = "budi";
            $user->password = password_hash("budi", PASSWORD_BCRYPT);
            $user->id = "budi";

            $this->userRepository->save($user);

            $_POST['id'] = "budi";
            $_POST['password'] = "budi";
            $this->userController->postLogin();

            $this::expectOutputRegex('[Location: /]');
        }
        public function testPostLoginIdNotFound(){
            $_POST['id'] = "budi";
            $_POST['password'] = "aaa";
            $this->userController->postLogin();

            $this->expectOutputRegex('/login/');
            $this->expectOutputRegex('<form>');
            $this->expectOutputRegex('[id or password is wrong]');
        }
        public function testPostLoginIdPasswordEmpty(){
            $_POST['id'] = "   ";
            $_POST['password'] = "  ";
            $this->userController->postLogin();

            $this->expectOutputRegex('/login/');
            $this->expectOutputRegex('<form>');
            $this->expectOutputRegex('[id and password cannot be empty]');
        }
        public function testPostLoginPasswordFailed(){
            $user = new User();
            $user->name = "budi";
            $user->password = password_hash("budi", PASSWORD_BCRYPT);
            $user->id = "budi";

            $this->userRepository->save($user);

            $_POST['id'] = "budi";
            $_POST['password'] = "budiono";
            $this->userController->postLogin();

            $this->expectOutputRegex('/login/');
            $this->expectOutputRegex('<form>');
            $this->expectOutputRegex('[id or password is wrong]');
        }

        public function testLogout(){
            $user = new User();
            $user->id = "budi";
            $user->name = "budi";
            $user->password = "budi";

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;

            $this->sessionRepository->save($session);

            $this->userController->logout();
            $this->expectOutputRegex('[PHP Login Management]');
            $this->expectOutputRegex("[Location: /]");
        }

        public function testPostUpdateProfile():void{
            $user = new User();
            $user->id = "budi";
            $user->name = "budi";
            $user->password = "budi";

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;

            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $_POST['name'] = "budiono";
            $this->userController->postUpdateProfile();

            self::expectOutputRegex("[Location: /]");

            $result = $this->userRepository->findById($user->id);
            self::assertEquals("budiono", $result->name);
        }

        public function testUpdateProfile(){
            $user = new User();
            $user->id = "budi";
            $user->name = "budi";
            $user->password = "budi";

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;

            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $this->userController->updateProfile();

            $this->expectOutputRegex('action="/users/profile">]');
            $this->expectOutputRegex("[update]");
        }

        public function testUpdateProfileValidationError(){
            $user = new User();
            $user->id = "budi";
            $user->name = "budi";
            $user->password = "budi";

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;

            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $_POST['name'] = "";
            $this->userController->postUpdateProfile();

            $this->expectOutputRegex('action="/users/profile">]');
            $this->expectOutputRegex("[update]");
            $this->expectOutputRegex("[name cannot be empty]");

        }

        public function testUpdatePassword(){
            $user = new User();
            $user->id = "budi";
            $user->name = "budi";
            $user->password = "budi";

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;

            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $this->userController->updatePassword();

            $this->expectOutputRegex('action="/users/password"]');
            $this->expectOutputRegex("[update]");
            $this->expectOutputRegex("[old password]");
            $this->expectOutputRegex("[new password]");
        }
        public function testPostUpdatePasswordSuccess(){
            $user = new User();
            $user->id = "budi";
            $user->name = "budi";
            $user->password = password_hash("budi", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;

            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $_POST['newPassword'] = "123456";
            $_POST['oldPassword'] = "budi";

            $this->userController->postUpdatePassword();
            self::expectOutputRegex("[Location: /]");

            $result = $this->userRepository->findById($user->id);
            self::assertTrue(password_verify("123456", $result->password));
        }

        public function testPostUpdatePasswordValidationError(){

            $user = new User();
            $user->id = "budi";
            $user->name = "budi";
            $user->password = password_hash("budi", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;

            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $_POST['newPassword'] = "   ";
            $_POST['oldPassword'] = "    ";

            $this->userController->postUpdatePassword();

            $this->expectOutputRegex('action="/users/password"]');
            $this->expectOutputRegex("[update]");
            $this->expectOutputRegex("[old password]");
            $this->expectOutputRegex("[new password]");
            $this->expectOutputRegex("[new password cannot be empty]");
        }

        public function testPostUpdateOldPasswordWrong(){
            $user = new User();
            $user->id = "budi";
            $user->name = "budi";
            $user->password = password_hash("budi", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;

            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $_POST['newPassword'] = "123";
            $_POST['oldPassword'] = "456";

            $this->userController->postUpdatePassword();

            $this->expectOutputRegex('action="/users/password"]');
            $this->expectOutputRegex("[update]");
            $this->expectOutputRegex("[old password]");
            $this->expectOutputRegex("[new password]");
            $this->expectOutputRegex("[old password is wrong]");
        }
}
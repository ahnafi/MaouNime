<?php

namespace MoView\App {
    function header(string $value)
    {
        echo $value;
    }
}

namespace MoView\Controller {

    use MoView\Config\Database;
    use MoView\Domain\User;
    use MoView\Exception\ValidationException;
    use MoView\Repository\UserRepository;
    use PHPUnit\Framework\TestCase;

    class UserControllerTest extends TestCase
    {

        private UserController $userController;
        private UserRepository $userRepository;

        public function setUp(): void
        {
            $this->userController = new UserController();
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
    }
}
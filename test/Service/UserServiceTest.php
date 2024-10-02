<?php

namespace MoView\Service;

use MoView\Config\Database;
use MoView\Domain\User;
use MoView\Exception\ValidationException;
use MoView\Model\UserRegisterRequest;
use MoView\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;

    protected function setUp(): void {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);

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
}

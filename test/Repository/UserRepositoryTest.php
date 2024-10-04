<?php

namespace MoView\Repository;

use MoView\Config\Database;
use MoView\Domain\User;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    public function setUp():void{
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess(){
        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = "123456";

        $this->userRepository->save($user);

        $result = $this->userRepository->findById("budi");
        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);

    }

    public function testFindByIdNotFound(){
        $user = $this->userRepository->findById("budionosiregar");

        self::assertNull($user);
    }

    public function testUpdateSuccess(){
        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = "123456";

        $this->userRepository->save($user);

        $user->name = "budionosiregar";
        $user->password = "555";

        $this->userRepository->update($user);

        $result = $this->userRepository->findById($user->id);

        $this->assertEquals("budionosiregar", $result->name);
        $this->assertEquals("555", $result->password);
    }

}

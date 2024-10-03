<?php

namespace MoView\Repository;

use MoView\Config\Database;
use MoView\Domain\Session;
use MoView\Domain\User;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{

    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function setUp(): void{
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->id = "budi";
        $user->name = "budi";
        $user->password = "budi";

        $this->userRepository->save($user);
    }

    public function testSaveSuccess(){
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "budi";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);
        self::assertEquals($session->id, $result->id);
        self::assertEquals($session->userId, $result->userId);
    }

    public function testDeleteByIdSuccess(){
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "budi";

        $this->sessionRepository->save($session);

        $this->sessionRepository->deleteById($session->id);

        $result = $this->sessionRepository->findById($session->id);
        self::assertNull($result);
    }

    public function testFindByIdNotFound(){
        $result = $this->sessionRepository->findById("budi");
        self::assertNull($result);
    }

}

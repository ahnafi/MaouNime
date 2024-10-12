<?php

namespace MoView\Repository;

use DateTime;
use MoView\Config\Database;
use MoView\Domain\Anime;
use MoView\Domain\Comment;
use MoView\Domain\User;
use PHPUnit\Framework\TestCase;

class CommentRepositoryTest extends TestCase
{

  private CommentRepository $commentRepository;
  private UserRepository $userRepository;
  private AnimeRepository $animeRepository;

  protected function setUp():void {
    date_default_timezone_set('Asia/Jakarta');

    $this->commentRepository = new CommentRepository(Database::getConnection());
    $this->userRepository = new UserRepository(Database::getConnection());
    $this->animeRepository = new AnimeRepository(Database::getConnection());

    $this->commentRepository->deleteAll();
    $this->animeRepository->deleteAll();
    $this->userRepository->deleteAll();
  }

  public function testSave():void {

    $anime = new Anime();
    $anime->id = 21;
    $anime->title = "Test anime";

    $user = new User();
    $user->id = "budi";
    $user->name = "budi";
    $user->password = "qwerty";

    $this->animeRepository->save($anime);
    $this->userRepository->save($user);

    $comment = new Comment();
    $comment->userId = $user->id;
    $comment->animeId = $anime->id;
    $comment->comment = "Test comment 1";
    $date = new DateTime();
    $comment->commentedAt = $date->format("Y-m-d H:i:s");

    $result = $this->commentRepository->save($comment);

    self::assertEquals($user->id,$result->userId);
    self::assertEquals($anime->id,$result->animeId);
    self::assertEquals($comment->comment,$result->comment);
    self::assertEquals($comment->commentedAt,$result->commentedAt);
    var_dump($result->commentedAt);
  }

  public function testdate(){
    $tgl = new DateTime();
    var_dump($tgl->format("Y-m-d H:i:s"));
    self::expectOutputRegex("[2024]");
  }

  public function testGetCommentsByAnimeID():void {
    $anime = new Anime();
    $anime->id = 21;
    $anime->title = "Test anime";

    $user = new User();
    $user->id = "budi";
    $user->name = "budi";
    $user->password = "qwerty";

    $this->animeRepository->save($anime);
    $this->userRepository->save($user);

    $comment = new Comment();
    $comment->userId = $user->id;
    $comment->animeId = $anime->id;
    $comment->comment = "Test comment 1";
    $date = new DateTime();
    $comment->commentedAt = $date->format("Y-m-d H:i:s");

    $this->commentRepository->save($comment);

    $comment->comment = "Test comment 2";
    $date = new DateTime();
    $comment->commentedAt = $date->format("Y-m-d H:i:s");

    $this->commentRepository->save($comment);

    $result = $this->commentRepository->getCommentByAnimeId($anime->id);
    self::assertEquals("Test comment 1", $result[0]->comment);
    self::assertEquals($result[1]->comment,$comment->comment);
    self::assertEquals($result[1]->animeId,$comment->animeId);
  }

  public function testGetCommentsByAnimeIdNull(){
    $result = $this->commentRepository->getCommentByAnimeId(21);
    self::assertNull($result);
  }


  public function testDeleteByID (){
    $anime = new Anime();
    $anime->id = 21;
    $anime->title = "Test anime";

    $user = new User();
    $user->id = "budi";
    $user->name = "budi";
    $user->password = "qwerty";

    $this->animeRepository->save($anime);
    $this->userRepository->save($user);

    $comment = new Comment();
    $comment->userId = $user->id;
    $comment->animeId = $anime->id;
    $comment->comment = "Test comment 1";
    $date = new DateTime();
    $comment->commentedAt = $date->format("Y-m-d H:i:s");

    $this->commentRepository->save($comment);

    $result = $this->commentRepository->getCommentByAnimeId($anime->id);

    self::assertEquals("Test comment 1", $result[0]->comment);

    $this->commentRepository->deleteById($result[0]->id);

    $find = $this->commentRepository->getCommentByAnimeId($anime->id);
    self::assertNull($find);
  }

}

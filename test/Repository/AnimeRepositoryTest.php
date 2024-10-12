<?php

namespace MoView\Repository;

use MoView\Config\Database;
use MoView\Domain\Anime;
use PHPUnit\Framework\TestCase;

class AnimeRepositoryTest extends TestCase
{

  private AnimeRepository $animeRepository;

  public function setUp(): void
  {
    $this->animeRepository = new AnimeRepository(Database::getConnection());

    $this->animeRepository->deleteAll();
  }

    public function testSave (){
      $anime = new Anime();
      $anime->id = 21;
      $anime->title = 'One Piece';

      $result = $this->animeRepository->save($anime);
      self::assertequals($anime->id, $result->id);
      self::assertequals($anime->title, $result->title);

    }

    public function testFindById (){
    $anime = new Anime();
    $anime->id = 21;
    $anime->title = 'One Piece';

    $this->animeRepository->save($anime);

    $result = $this->animeRepository->findById(21);
    self::assertequals($anime->id, $result->id);
    }
}

<?php

namespace MoView\Repository;

use MoView\Domain\Anime;

class AnimeRepository
{

  private ?\PDO $connection = null;

  public function __construct(?\PDO $connection)
  {
    $this->connection = $connection;
  }

  public function save (Anime $anime):Anime {
    $statement = $this->connection->prepare("INSERT INTO animes (id,title) VALUES (?,?)");
    $statement->execute([$anime->id, $anime->title]);
    return $anime;
  }

  public function findById(int $id): ?Anime {
    $statement = $this->connection->prepare("SELECT id,title FROM animes WHERE id = ?");
    $statement->execute([$id]);

    try {
      if($row = $statement->fetch()) {
        $anime = new Anime();
        $anime->id = $row['id'];
        $anime->title = $row['title'];
        return $anime;
      }else {
        return null;
      }
    } finally {
      $statement->closeCursor();
    }
  }

  public function deleteAll():void{
    $this->connection->query("DELETE FROM animes");
  }


}
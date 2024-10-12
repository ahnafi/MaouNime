<?php

namespace MoView\Repository;

use MoView\Domain\Comment;

class CommentRepository
{
  public ?\PDO $connection = null;

  public function __construct(?\PDO $connection)
  {
    $this->connection = $connection;
  }

  public function save(Comment $comment): Comment{
    $statement = $this->connection->prepare("INSERT INTO comments (user_id,anime_id,comment,commented_at) VALUES (?,?,?,?)");
    $statement->execute([$comment->userId,$comment->animeId,$comment->comment,$comment->commentedAt]);
    return $comment;
  }

  public function getCommentByAnimeId(int $animeId):?array {
    $statement = $this->connection->prepare("SELECT id, user_id, anime_id, comment, commented_at FROM comments WHERE anime_id = ? ORDER BY id DESC ");
    $statement->execute([$animeId]);

    $rows = $statement->fetchAll();

    if(empty($rows)){
      return null;
    }

    $comments = [];

    foreach($rows as $row){

      $comment = new Comment();
      $comment->id = $row["id"];
      $comment->userId = $row["user_id"];
      $comment->animeId = $row["anime_id"];
      $comment->comment = $row["comment"];
      $comment->commentedAt = $row["commented_at"];

      $comments[] = $comment;
    }

    return $comments;
  }

  public function deleteById(int $id): void
  {
    $statement = $this->connection->prepare("DELETE FROM comments WHERE id=?");
    $statement->execute([$id]);
  }

  public function deleteAll():void{
    $this->connection->exec("DELETE FROM comments");
  }

}
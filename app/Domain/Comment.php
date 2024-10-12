<?php

namespace MoView\Domain;

class Comment
{
  public ?int $id = null;
  public string $userId;
  public int $animeId;
  public string $comment;
  public string $commentedAt;
}
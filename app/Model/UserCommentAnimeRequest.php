<?php

namespace MoView\Model;

class UserCommentAnimeRequest
{
  public string $userId;
  public int $animeId;
  public string $animeTitle;
  public string $comment;
  public string $commentedAt;
}
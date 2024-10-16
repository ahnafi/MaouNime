<?php

namespace MoView\Domain;

class Rating
{
  public int $id;
  public ?string $userId;
  public ?int $animeId;
  public ?int $rating;
}
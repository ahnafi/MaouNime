<?php

namespace MoView\Domain;

class WatchList
{
  public int $id;
  public string $userId;
  public int $animeId;
  public string $status;
  public string $img;
  public string $synopsis;
}
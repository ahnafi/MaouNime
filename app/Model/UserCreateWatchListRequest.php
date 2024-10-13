<?php

namespace MoView\Model;

class UserCreateWatchListRequest {
    public string $userId;
    public int $animeId;
    public string $animeTitle;
    public string $status;
    public string $img;
}
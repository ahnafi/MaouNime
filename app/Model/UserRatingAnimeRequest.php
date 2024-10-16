<?php 

namespace MoView\Model;

class UserRatingAnimeRequest {
    public string $userId;
    public ?int $animeId;
    public ?int $rating;
    public ?string $animeTitle;
}
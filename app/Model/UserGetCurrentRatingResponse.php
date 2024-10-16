<?php

namespace MoView\Model;
use MoView\Domain\Rating;

class UserGetCurrentRatingResponse {
    public ?Rating $rating;
    public ?float $score;
}
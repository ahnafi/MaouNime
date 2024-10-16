<?php

namespace MoView\Repository;
use MoView\Domain\Rating;

class RatingRepository
{

    public \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Rating $rating): Rating
    {
        $statement = $this->connection->prepare("INSERT INTO ratings (user_id,anime_id,rating) VALUES (?,?,?)");
        $statement->execute([$rating->userId, $rating->animeId, $rating->rating]);
        return $rating;
    }

    public function update(Rating $rating): Rating
    {
        $statement = $this->connection->prepare("UPDATE ratings SET rating = ? WHERE user_id = ? AND anime_id = ?");
        $statement->execute([$rating->rating, $rating->userId, $rating->animeId]);
        return $rating;
    }

    public function avgRating(int $animeId): ?float
    {
        $statement = $this->connection->prepare("SELECT AVG(rating) FROM ratings WHERE anime_id = ?");
        $statement->execute([$animeId]);
        
        try {
            if ($row = $statement->fetch()) {
                return round($row[0],2);
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findRating(Rating $rating): ?Rating
    {
        $statement = $this->connection->prepare("SELECT id,anime_id,user_id,rating FROM ratings where user_id = ? AND anime_id = ?");
        $statement->execute([$rating->userId, $rating->animeId]);

        try {
            if ($row = $statement->fetch()) {
                $rating = new Rating();
                $rating->id = $row["id"];
                $rating->animeId = $row["anime_id"];
                $rating->userId = $row["user_id"];
                $rating->rating = $row["rating"];
                return $rating;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }

    }

    public function delete(Rating $rating)
    {
        $statement = $this->connection->prepare("DELETE FROM ratings WHERE user_id = ? AND anime_id = ?");
        $statement->execute([$rating->userId, $rating->animeId]);
    }

    public function deleteAll()
    {
        $this->connection->exec("DELETE FROM ratings");
    }
}
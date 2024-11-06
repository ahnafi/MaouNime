<?php

namespace MoView\Repository;
use MoView\Domain\WatchList;

class WatchListRepository
{

    public ?\PDO $connection = null;

    public function __construct(?\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(WatchList $watchList): WatchList
    {
        $statement = $this->connection->prepare("INSERT INTO watchlist (user_id,anime_id,status,img,synopsis) VALUES (?,?,?,?,?)");
        $statement->execute([$watchList->userId, $watchList->animeId, $watchList->status, $watchList->img,$watchList->synopsis]);
        return $watchList;
    }

    public function getWatchListByUserId(string $userId): ?array
    {
        $statement = $this->connection->prepare("SELECT id, user_id, anime_id, status, img,synopsis FROM watchlist WHERE user_id = ? ORDER BY id DESC ");
        $statement->execute([$userId]);

        $rows = $statement->fetchAll();

        if (empty($rows)) {
            return null;
        }

        $watchLists = [];

        foreach ($rows as $row) {

            $watchList = new WatchList();
            $watchList->id = $row["id"];
            $watchList->userId = $row["user_id"];
            $watchList->animeId = $row["anime_id"];
            $watchList->status = $row["status"];
            $watchList->img = $row["img"];
            $watchList->synopsis = $row["synopsis"];

            $watchLists[] = $watchList;
        }

        return $watchLists;
    }

    public function getWatchListByUserIdAndAnimeId(string $userId, int $animeId): ?WatchList
    {
        $statement = $this->connection->prepare("SELECT id, user_id, anime_id, status, img,synopsis FROM watchlist WHERE user_id = ? AND anime_id = ?");
        $statement->execute([$userId, $animeId]);

        try {
            $row = $statement->fetch();

            if (empty($row)) {
                return null;
            }

            $watchList = new WatchList();
            $watchList->id = $row["id"];
            $watchList->userId = $row["user_id"];
            $watchList->animeId = $row["anime_id"];
            $watchList->status = $row["status"];
            $watchList->img = $row["img"];
            $watchList->synopsis = $row["synopsis"];

            return $watchList;
        } finally {
            $statement->closeCursor();
        }
    }

    public function updateStatus(string $status, int $watchListId): void
    {
        $statement = $this->connection->prepare("UPDATE watchlist SET status=? WHERE id=?");
        $statement->execute([$status, $watchListId]);
    }

    public function deleteById(int $id): void
    {
        $statement = $this->connection->prepare("DELETE FROM watchlist WHERE id = ?");
        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM watchlist");
    }

}
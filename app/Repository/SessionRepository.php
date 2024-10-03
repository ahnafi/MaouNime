<?php

namespace MoView\Repository;

use MoView\Domain\Session;

class SessionRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection){
        $this->connection = $connection;
    }

    public function save(Session $session):Session {
        $connection = $this->connection->prepare("INSERT INTO sessions (id,user_id) values (?,?) ");
        $connection->execute([$session->id,$session->userId]);
        return $session;
    }

    public function findById(string $id):?Session {
        $connection = $this->connection->prepare("SELECT id,user_id FROM sessions WHERE id = ?");
        $connection->execute([$id]);

        try{
            if($row = $connection->fetch()){
                $session = new Session();
                $session->id = $row['id'];
                $session->userId = $row['user_id'];
                return $session;
            }else{
                return null;
            }
        } finally {
            $connection->closeCursor();
        }
    }

    public function deleteById(string $id):void {
        $connection = $this->connection->prepare("DELETE FROM sessions WHERE id = ?");
        $connection->execute([$id]);
    }

    public function deleteAll():void{
        $this->connection->exec("DELETE FROM sessions");
    }
}
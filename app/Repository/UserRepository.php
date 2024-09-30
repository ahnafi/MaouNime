<?php 


class UserRepository
{
    private \PDO $connection;
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function index()
    {}
}
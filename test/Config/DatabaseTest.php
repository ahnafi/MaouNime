<?php

namespace MoView\Config;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testGetConnection()
    {
        $connection = Database::getConnection();
        self::assertNotNull($connection);
    }

    public function testGetConnectionSingleton()
    {
        $connection = Database::getConnection();
        $connection2 = Database::getConnection();
        self::assertSame($connection, $connection2);
    }

}
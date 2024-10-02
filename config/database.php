<?php

function getDatabaseConfig(): array
{
    return [
        "database" => [
            "test" => [
                "url" => "mysql:host=localhost:3306;dbname=moview_test",
                "username" => "speed",
                "password" => "qwerty"
            ],
            "prod" => [
                "url" => "mysql:host=localhost:3306;dbname=moview",
                "username" => "speed",
                "password" => "qwerty"
            ]
        ]
    ];
}
<?php

namespace MoView\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testRender()
    {
        View::render("Home/index",["phpunit index"]);

        $this->expectOutputRegex('[phpunit index]');
        $this->expectOutputRegex('[<body>]');
        $this->expectOutputRegex('[index home]');
    }
}

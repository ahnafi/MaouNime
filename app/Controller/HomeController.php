<?php

namespace MoView\Controller;
use MoView\App\View;

class HomeController
{
    public function index():void
    {
        View::render("Home/index", [
            "title" => "Home"
        ]);
    }
}
<?php

namespace MoView\App {

    function header(string $value): void
    {
        echo $value;
    }

}

namespace MoView\Service {

    function setcookie(string $name, string $value): void
    {
        echo "$name: $value";
    }

}
<?php

namespace MoView\App {

    function header(string $value){
        echo $value;
    }

}

namespace MoView\Service {

    function setcookie(string $name, string $value){
        echo "$name: $value";
    }

}
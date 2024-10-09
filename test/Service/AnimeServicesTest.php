<?php

namespace MoView\Service;

use PHPUnit\Framework\TestCase;

class AnimeServicesTest extends TestCase
{
    public AnimeServices $animeServices;

    public function setUp():void {
        $this->animeServices = new AnimeServices();
    }

    function testGetAnimeAiring()
    {
        $anime = $this->animeServices->getAnimeById(21);
        self::assertNotEmpty($anime);
        self::assertEquals('One Piece', $anime['title']);
    }


}

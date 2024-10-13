<?php

namespace MoView\Service;

use PHPUnit\Framework\TestCase;

class AnimeServicesTest extends TestCase
{
    public AnimeService $animeServices;

    public function setUp():void {
        $this->animeServices = new AnimeService();
    }

    function testGetAnimeAiring()
    {
        $anime = $this->animeServices->getAnimeById(21);
        self::assertNotEmpty($anime);
        self::assertEquals('One Piece', $anime['title']);
    }


}

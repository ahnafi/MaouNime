<?php

namespace MoView\Service;

use MoView\Domain\Anime;
use MoView\Repository\AnimeRepository;

class AnimeServices
{

    private string $apiBaseUrl = 'https://api.jikan.moe/v4';
//    public AnimeRepository $animeRepository;
//
//  public function __construct(AnimeRepository $animeRepository)
//  {
//    $this->animeRepository = $animeRepository;
//  }


  public function searchAnime(string $keyword) : mixed
    {
        $url = $this->apiBaseUrl . '/anime?sfw=true&' . $keyword;
        return $this->makeApiRequest($url);
    }

    public function getAnimeRecomendation():mixed
    {
      $url = $this->apiBaseUrl . '/recomendations/anime';
      return $this->makeApiRequest($url);
    }

    public function getAnimeById(string $id):mixed{
      $url = $this->apiBaseUrl . '/anime/' . $id;
      return $this->makeApiRequest($url);
    }

    private function makeApiRequest($url)
    {
        // Inisialisasi cURL
        $ch = curl_init();

        // Set opsi cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Eksekusi cURL dan simpan responsnya
        $response = curl_exec($ch);

        // Cek apakah terjadi error
        if (curl_errno($ch)) {
            curl_close($ch);
            return [];
        }

        // Tutup cURL
        curl_close($ch);

        // Decode data JSON
        return json_decode($response, true);
    }

//    public function DBanimeSave() {
//
//      try {
//        $anime = new Anime();
//
//
//        $this->animeRepository->save();
//
//      }catch (\Exception $e){
//
//      }
//    }
//
//    private function validateAnimeSaveRequest (){
//
//    }
}
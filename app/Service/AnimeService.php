<?php

namespace MoView\Service;

use MoView\Repository\CommentRepository;

class AnimeService
{

    private string $apiBaseUrl = 'https://api.jikan.moe/v4';
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository){
      $this->commentRepository = $commentRepository;
    }


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

    public function getAnimeFile(string $path):array {
      // $pathFile = __DIR__ . "/../Data/topScoreAnime.json";
      $jsonData = file_get_contents($path);
      
      if($jsonData === false){
        return [];
      }

      return json_decode($jsonData, true);
    }

    public function getPopularAnimeCommented(): array
    {
      $animesId = $this->commentRepository->popularCommentAnimeID();

      if(empty($animesId)){
        return [];
      }

      $animes = [];

      foreach ($animesId as $animeId){
        $result = $this->getAnimeById($animeId);

        $animes[] = $result['data'];
      }

      return $animes;
    }
}
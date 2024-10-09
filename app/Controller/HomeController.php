<?php

namespace MoView\Controller;
use MoView\App\View;
use MoView\Config\Database;
use MoView\Repository\SessionRepository;
use MoView\Repository\UserRepository;
use MoView\Service\AnimeServices;
use MoView\Service\SessionService;

class HomeController
{
    private SessionService $sessionService;
    private AnimeServices $animeServices;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);

        $this->animeServices = new AnimeServices();
    }

    public function Error404(): void
    {
        View::render('Error/404', [
            "title" => "Error 404"
        ]);
    }

    public function index(): void
    {
        $user = $this->sessionService->current();
        $data = [
            "title" => "MaouNime anime wiki",
        ];

        if ($user !== null) {
            $data["user"] = [
                "name" => $user->name,
            ];
        }

        View::render('Home/index', $data);
    }

    public function anime(): void
    {
        $user = $this->sessionService->current();
        $topScore = $this->animeServices->searchAnime("type=tv&order_by=score&sort=desc")['data'];
        $upComing = $this->animeServices->searchAnime("status=upcoming&type=tv")['data'];
        $data = [
            "title" => "MaouNime anime wiki",
            'anime' => [
                "topScore" => $topScore,
                "upComing" => $upComing,
            ],
        ];

        if ($user !== null) {
            $data["user"] = [
                "name" => $user->name,
            ];
        }

        View::render('Anime/index', $data);
    }

    public function searchAnime(): void
    {
        $queryParams = [
            "q" => htmlspecialchars($_GET["title"]),
            "type" => htmlspecialchars($_GET["type"]),
            "min_score" => htmlspecialchars($_GET["score"]),
            "status" => htmlspecialchars($_GET["status"]),
            "rating" => htmlspecialchars($_GET["rating"]),
            "page"=> htmlspecialchars($_GET["page"]),
            "order_by" => htmlspecialchars($_GET["order_by"]),
            "sort" => htmlspecialchars($_GET["sort"]),
        ];

        // Menggabungkan parameter menjadi string query
        $keyword = http_build_query($queryParams);

        $user = $this->sessionService->current();
        $anime = $this->animeServices->searchAnime($keyword);
        $data = [
            "title" => "MaouNime anime wiki",
            'anime' => $anime,
        ];

        if ($user !== null) {
            $data["user"] = [
                "name" => $user->name,
            ];
        }

        View::render('Anime/search', $data);
    }

    public function detailAnime($id): void
    {
        $user = $this->sessionService->current();
        $anime = $this->animeServices->getanimeById($id);

        if($anime["status"] === 404){
            View::redirect('/anime');
        }

        $data = [
            "title" => "MaouNime anime wiki",
            'anime' => $anime,
        ];

        if ($user !== null) {
            $data["user"] = [
                "name" => $user->name,
            ];
        }

        View::render('Anime/detail', $data);
    }
}

<?php

namespace MoView\Controller;
use MoView\App\View;
use MoView\Config\Database;
use MoView\Domain\Rating;
use MoView\Exception\ValidationException;
use MoView\Model\UserCommentAnimeRequest;
use MoView\Model\UserCreateWatchListRequest;
use MoView\Model\UserGetCurrentRatingRequest;
use MoView\Model\UserRatingAnimeRequest;
use MoView\Repository\AnimeRepository;
use MoView\Repository\CommentRepository;
use MoView\Repository\RatingRepository;
use MoView\Repository\SessionRepository;
use MoView\Repository\UserRepository;
use MoView\Repository\WatchListRepository;
use MoView\Service\AnimeService;
use MoView\Service\CommentService;
use MoView\Service\RatingService;
use MoView\Service\SessionService;
use MoView\Service\WatchListService;

class HomeController
{
    private SessionService $sessionService;
    private AnimeService $animeServices;
    private CommentService $commentServices;
    private WatchListService $watchListService;
    private RatingService $ratingService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);

        $commentRepository = new CommentRepository($connection);
        $animeRepository = new AnimeRepository($connection);
        $this->animeServices = new AnimeService($commentRepository);
        $this->commentServices = new CommentService($commentRepository,$userRepository,$animeRepository);

        $watchListRepository = new WatchListRepository($connection);
        $this->watchListService =  new WatchListService($watchListRepository,$animeRepository,$userRepository);

        $ratingRepository = new RatingRepository($connection);
        $this->ratingService = new RatingService($ratingRepository,$animeRepository,$userRepository);
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
        $topScore = $this->animeServices->getAnimeFile(__DIR__ . "/../Data/topScoreAnime.json");
        $upComing = $this->animeServices->getAnimeFile(__DIR__ . "/../Data/airingAnime.json");
        $commentedAnime = $this->animeServices->getPopularAnimeCommented();
        $data = [
            "title" => "MaouNime anime wiki",
            'anime' => [
                "topScore" => $topScore,
                "upComing" => $upComing,
              "comented" => $commentedAnime,
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
      "q" => htmlspecialchars($_GET["title"] ?? ''),
      "type" => htmlspecialchars($_GET["type"] ?? ''),
      "min_score" => htmlspecialchars($_GET["score"] ?? ''),
      "status" => htmlspecialchars($_GET["status"] ?? ''),
      "rating" => htmlspecialchars($_GET["rating"] ?? ''),
      "page" => htmlspecialchars($_GET["page"] ?? 1),
      "order_by" => htmlspecialchars($_GET["order_by"] ?? ''),
      "sort" => htmlspecialchars($_GET["sort"] ?? 'asc'),
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

    // Ambil data anime berdasarkan ID
    $anime = $this->animeServices->getanimeById($id);

    // Ambil komentar berdasarkan ID anime
    $comments = $this->commentServices->getCommentByAnimeId($id);

    // ambil rata rata anime rating
    $rating = new UserGetCurrentRatingRequest();
    $rating->animeId = $id;
    $rating->userId = $user->id;

    $rating = $this->ratingService->currentRating($rating);

    // Jika anime tidak ditemukan atau ada kesalahan status, redirect ke halaman anime
    if (isset($anime["status"])) {
      View::redirect('/anime');
    }

    // Siapkan data untuk dikirim ke view
    $data = [
      "title" => "MaouNime anime wiki",
      'anime' => $anime,
      'comments' => $comments,
      'rating' => $rating,
    ];

    // Jika user login, tambahkan informasi user
    if ($user !== null) {
      $data["user"] = [
        "name" => $user->name,
      ];
    }

    // Render tampilan detail anime
    View::render('Anime/detail', $data);
  }

  public function postComment(): void {
    $date = new \DateTime();
    $user = $this->sessionService->current();

    $request = new UserCommentAnimeRequest();
    $request->animeId = (int) htmlspecialchars($_POST["animeId"]);
    $request->animeTitle = htmlspecialchars($_POST["animeTitle"]);
    $request->comment = htmlspecialchars($_POST["comment"]);
    $request->userId = $user->id;
    $request->commentedAt = $date->format("Y-m-d H:i:s");

    try {
      $this->commentServices->createComment($request);
      View::redirect("/anime/detail/" . $request->animeId);
    } catch (ValidationException $exception) {
      // Jika ada error, kembalikan ke halaman detail dengan pesan error

        // unhandle error

      View::redirect("/anime/detail/" . $request->animeId);
    }
  }

  public function postWatchlist():void {
    $user = $this->sessionService->current();

    $request = new UserCreateWatchListRequest();
    $request->userId = $user->id;
    $request->animeId = (int) htmlspecialchars($_POST["animeId"]);
    $request->img = htmlspecialchars($_POST['img']);
    $request->status = "plan to watch";
    $request->animeTitle = htmlspecialchars($_POST['animeTitle']);

    try{
      $this->watchListService->createWatchList($request);
      
      View::redirect("/anime/detail/" . $request->animeId);
    }catch(ValidationException $err){

      // unhandle error

      View::redirect("/anime/detail/" . $request->animeId);
    }
  }

  public function postRating (){
    $user = $this->sessionService->current();

    $request = new UserRatingAnimeRequest();
    $request->userId = $user->id;
    $request->animeId = (int) htmlspecialchars($_POST["animeId"]);
    $request->rating = (int) htmlspecialchars($_POST["rating"]);
    $request->animeTitle = htmlspecialchars($_POST["animeTitle"]);

    try{
      $this->ratingService->ratingAnime($request);
      View::redirect("/anime/detail/" . $request->animeId);
    }catch(ValidationException $err){

      // unhandle error

      View::redirect("/anime/detail/" . $request->animeId);
    }
  }

}

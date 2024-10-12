<?php

namespace MoView\Controller;
use MoView\App\View;
use MoView\Config\Database;
use MoView\Exception\ValidationException;
use MoView\Model\UserCommentAnimeRequest;
use MoView\Repository\AnimeRepository;
use MoView\Repository\CommentRepository;
use MoView\Repository\SessionRepository;
use MoView\Repository\UserRepository;
use MoView\Service\AnimeServices;
use MoView\Service\CommentServices;
use MoView\Service\SessionService;

class HomeController
{
    private SessionService $sessionService;
    private AnimeServices $animeServices;
    private CommentServices $commentServices;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);

        $commentRepository = new CommentRepository($connection);
        $animeRepository = new AnimeRepository($connection);
        $this->animeServices = new AnimeServices();
        $this->commentServices = new CommentServices($commentRepository,$userRepository,$animeRepository);
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

    // Ambil data anime berdasarkan ID
    $anime = $this->animeServices->getanimeById($id);

    // Ambil komentar berdasarkan ID anime
    $comments = $this->commentServices->getCommentByAnimeId($id);

    // Jika anime tidak ditemukan atau ada kesalahan status, redirect ke halaman anime
    if (isset($anime["status"])) {
      View::redirect('/anime');
    }

    // Siapkan data untuk dikirim ke view
    $data = [
      "title" => "MaouNime anime wiki",
      'anime' => $anime,
      'comments' => $comments, // Tambahkan komentar ke dalam data yang dikirim ke view
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

    if ($user === null) {
      // Redirect to login page if user is not logged in
      View::redirect('/users/login');
      return;
    }

    $request = new UserCommentAnimeRequest();
    $request->animeId = htmlspecialchars($_POST["animeId"]);
    $request->animeTitle = htmlspecialchars($_POST["animeTitle"]);
    $request->comment = htmlspecialchars($_POST["comment"]);
    $request->userId = $user->id;
    $request->commentedAt = $date->format("Y-m-d H:i:s");

    try {
      $this->commentServices->createComment($request);
      View::redirect("/anime/detail/" . $request->animeId);
    } catch (ValidationException $exception) {
      // Jika ada error, kembalikan ke halaman detail dengan pesan error
      View::redirect("/anime/detail/" . $request->animeId);
    }
  }

}

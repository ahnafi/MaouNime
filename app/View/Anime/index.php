<?php

$topScore = array_slice($model['anime']['topScore'], 0, 8) ?? [];
$upComing = array_slice($model['anime']['upComing'], 0, 8) ?? [];
$tvAnime = array_slice($model['anime']['tv'], 0, 8) ?? [];
$ovaAnime = array_slice($model["anime"]["ova"], 0, 8) ?? [];
$movie = array_slice($model["anime"]["movie"], 0, 8) ?? [];

$animes = [
    [
        'title' => 'Top Score Anime',
        'link' => '/anime/search?type=tv&order_by=score&sort=desc',
        'animes' => $topScore,
    ],
    [
        'title' => 'Upcoming Anime',
        'link' => '/anime/search?status=upcoming&type=tv&sort=desc',
        'animes' => $upComing,
    ],
    [
        'title' => 'TV Anime',
        'link' => '/anime/search?type=tv&sort=desc',
        'animes' => $tvAnime,
    ],
    [
        'title' => 'OVA Anime',
        'link' => '/anime/search?type=ova&sort=desc',
        'animes' => $ovaAnime,
    ],
    [
        'title' => 'Movie Anime',
        'link' => '/anime/search?type=movie&sort=desc',
        'animes' => $movie,
    ],
];

// navbar taruh di awal php biar gak error
include_once __DIR__ . "/../Components/navbar.php";
?>

<style>
    .anime-slide {
        scrollbar-width: none;
    }

    .anime-slide:hover {
        scrollbar-width: auto;
    }

    .card-size {
        width: 16rem;
        height: 20rem;
    }

    .card {
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: center;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
    }

    .card:hover {
        transform: scale(0.99);
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        background-size: 120%;
    }

    .card-meta {
        color: rgba(0, 0, 0, 0.3);
        text-transform: uppercase;
        font-weight: 500;
        letter-spacing: 2px;
    }

    .card-body {
        background: #fff;
        background: linear-gradient(0deg, rgba(0, 0, 0, .6), rgba(200, 200, 200, .2));
        transition: all 0.5s ease-in-out; /* Transisi untuk efek halus */
    }

    .card-body:hover {
        background: linear-gradient(0deg, rgba(0, 0, 0, .9), rgba(200, 200, 200, .2));
    }

    .card-title {
        font-weight: 800;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        cursor: pointer;
        transition: max-height 0.6s ease-in-out, opacity 0.3s ease-in-out; /* Transisi animasi */
        max-height: 1.2em;
        opacity: 1;
    }

    .card:hover .card-title {
        white-space: normal;
        overflow: visible;
        max-height: 10em;
        opacity: 1;
    }

    #jumbotron {
        max-height: 70vh;
        background-image: linear-gradient(90deg, rgba(0, 212, 255, 0.196) 0%, rgba(9, 9, 121, 0.373) 45%, rgba(2, 0, 36, 0.667) 100%),
        url("/images/jumbotron.webp");
        background-position: bottom center;
        background-size: cover;
        background-attachment: fixed;
        background-repeat: no-repeat;
        overflow: hidden;
    }

    @media (max-width: 760px) {
        #jumbotron {
            background-image: linear-gradient(90deg, rgba(2, 0, 36, 0.6671918767507004) 0%, rgba(9, 9, 121, 0.37307422969187676) 45%, rgba(0, 212, 255, 0.1966036414565826) 100%), url("/images/jumbotron.webp");
            height: 66vh;
        }
    }

    .megumin {
        /*max-width: calc(50%);*/
        min-width: calc(40%);
    }

</style>
<div class="container-fluid ">
    <!--    jumbotron-->
    <div class="row" id="jumbotron">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="/images/megumin.gif" alt="megumin chibi" class="megumin d-none d-md-block p-2">
        </div>
        <div class="col-md-6 pb-5 pb-md-5 d-flex justify-content-center align-items-center">
            <div class="col-10 pb-5 pb-md-0">
                <h1 class="fw-bold text-white ">Cari Informasi Tentang Anime Hanya Di <span
                            class="text-primary text-bg-dark">Maounime</span>
                </h1>
                <a href="/anime/search?type=tv&order_by=score&sort=desc" class="btn btn-primary shadow">Jelajahi
                    Sekarang!</a>
            </div>
        </div>
    </div>
    <!--    jumbotron end-->

    <!-- anime -->
    <?php foreach ($animes as $anime): ?>
        <div class="row pt-3">
            <div class="col">
                <h2><?= $anime['title'] ?></h2>
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <a href="<?= $anime['link'] ?>" class="fw-semibold link-dark">Show More</a>
            </div>
        </div>

        <div class="row">
            <div class="anime-slide col-12 gap-3 d-flex overflow-x-scroll py-2">
                <?php foreach ($anime['animes'] as $animeItem): ?>
                    <a href="/anime/detail/<?= $animeItem["mal_id"] ?>" class="text-decoration-none">
                        <div class="card card-size "
                             style="background-image: url('<?= $animeItem["images"]["webp"]["image_url"] ?>')">
                            <div class="card-body d-flex justify-content-start align-content-end flex-column-reverse">
                                <h6 class="card-title fw-bold text-white"><?= $animeItem["title"] ?></h6>
                                <?php if (isset($animeItem['score'])): ?>
                                    <p class="card-meta fw-medium text-white">Score : <?= $animeItem["score"] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- anime ends -->
</div>
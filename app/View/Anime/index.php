<?php

$topScore = array_slice($model['anime']['topScore'], 0, 8) ?? [];
$upComing = array_slice($model['anime']['upComing'], 0, 8) ?? [];
$tvAnime = array_slice($model['anime']['tv'], 0, 8) ?? [];
$ovaAnime = array_slice($model["anime"]["ova"], 0, 8) ?? [];
$movie = array_slice($model["anime"]["movie"], 0, 8) ?? [];

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
</style>
<div class="container-fluid ">
    <!-- search bar -->
    <?php include_once __DIR__ . "/../Components/search.php"; ?>
    <!-- end search bar -->

    <!-- top score anime -->
    <div class="row py-3">
        <div class="col">
            <h2>top score anime</h2>
        </div>
        <div class="col d-flex justify-content-end align-items-center">
            <a href="/anime/search?type=tv&order_by=score&sort=desc" class="link">More</a>
        </div>
    </div>

    <div class="row py-3">
        <div class="anime-slide col-12 gap-3 d-flex overflow-x-scroll py-2">
            <?php foreach ($topScore as $animeItem): ?>
                <a href="/anime/detail/<?= $animeItem["mal_id"] ?>" class="text-decoration-none">
                    <div class="card card-size "
                         style="background-image: url('<?= $animeItem["images"]["webp"]["image_url"] ?>')">
                        <div class="card-body d-flex justify-content-start align-content-end flex-column-reverse">
                            <h6 class="card-title fw-bold text-white"><?= $animeItem["title"] ?></h6>
                            <p class="card-meta fw-medium text-white">Score : <?= $animeItem["score"] ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- top score anime -->
    <!-- upcoming anime -->
    <div class="row py-3">
        <div class="col-6">
            <h2>Upcoming Anime</h2>
        </div>
        <div class="col d-flex justify-content-end align-items-center">
            <a href="/anime/search?status=upcoming&type=tv&sort=desc" class="link">More</a>
        </div>
    </div>
    <div class="row py-3">
        <div class="anime-slide col-12 gap-3 d-flex overflow-x-scroll py-2">
            <?php foreach ($upComing as $animeItem): ?>
                <a href="/anime/detail/<?= $animeItem["mal_id"] ?>" class="text-decoration-none">
                    <div class="card card-size "
                         style="background-image: url('<?= $animeItem["images"]["webp"]["image_url"] ?>')">
                        <div class="card-body d-flex justify-content-start align-content-end flex-column-reverse">
                            <h6 class="card-title fw-bold text-white"><?= $animeItem["title"] ?></h6>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end tile -->
    <!-- tv anime -->
    <div class="row py-3">
        <div class="col-6">
            <h2>TV Anime</h2>
        </div>
        <div class="col d-flex justify-content-end align-items-center">
            <a href="/anime/search?type=tv&sort=desc" class="link">More</a>
        </div>
    </div>
    <div class="row py-3">
        <div class="anime-slide col-12 gap-3 d-flex overflow-x-scroll py-2">
            <?php foreach ($tvAnime as $animeItem): ?>
                <a href="/anime/detail/<?= $animeItem["mal_id"] ?>" class="text-decoration-none">
                    <div class="card card-size "
                         style="background-image: url('<?= $animeItem["images"]["webp"]["image_url"] ?>')">
                        <div class="card-body d-flex justify-content-start align-content-end flex-column-reverse">
                            <h6 class="card-title fw-bold text-white"><?= $animeItem["title"] ?></h6>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end tile -->
    <!-- ova anime -->
    <div class="row py-3">
        <div class="col-6">
            <h2>OVA Anime</h2>
        </div>
        <div class="col d-flex justify-content-end align-items-center">
            <a href="/anime/search?type=ova&sort=desc" class="link">More</a>
        </div>
    </div>
    <div class="row py-3">
        <div class="anime-slide col-12 gap-3 d-flex overflow-x-scroll py-2">
            <?php foreach ($ovaAnime as $animeItem): ?>
                <a href="/anime/detail/<?= $animeItem["mal_id"] ?>" class="text-decoration-none">
                    <div class="card card-size "
                         style="background-image: url('<?= $animeItem["images"]["webp"]["image_url"] ?>')">
                        <div class="card-body d-flex justify-content-start align-content-end flex-column-reverse">
                            <h6 class="card-title fw-bold text-white"><?= $animeItem["title"] ?></h6>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end tile -->
    <!-- movie anime -->
    <div class="row py-3">
        <div class="col-6">
            <h2>Movie Anime</h2>
        </div>
        <div class="col d-flex justify-content-end align-items-center">
            <a href="/anime/search?type=movie&sort=desc" class="link">More</a>
        </div>
    </div>
    <div class="row py-3">
        <div class="anime-slide col-12 gap-3 d-flex overflow-x-scroll py-2">
            <?php foreach ($movie as $animeItem): ?>
                <a href="/anime/detail/<?= $animeItem["mal_id"] ?>" class="text-decoration-none">
                    <div class="card card-size "
                         style="background-image: url('<?= $animeItem["images"]["webp"]["image_url"] ?>')">
                        <div class="card-body d-flex justify-content-start align-content-end flex-column-reverse">
                            <h6 class="card-title fw-bold text-white"><?= $animeItem["title"] ?></h6>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end tile -->
</div>
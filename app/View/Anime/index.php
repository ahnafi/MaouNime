<?php

$topScore = array_slice($model['anime']['topScore'], 0, 8) ?? [];
$upComing = array_slice($model['anime']['upComing'], 0, 8) ?? [];
$comented = $model['anime']['comented'] ?? null;

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
<div class="container-fluid">
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
        <div class="anime-slide col-12 gap-3 d-flex overflow-x-scroll ">
            <?php foreach ($topScore as $animeItem): ?>
                <div class="card col-6" style="width: 16rem;">
                    <img src="<?= $animeItem['images']['webp']['image_url'] ?>" loading="lazy" class="card-img-top"
                        alt="image <?= $animeItem['title'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($animeItem['title'], ENT_QUOTES, 'UTF-8') ?></h5>
                        <p class="card-text">Global Score <?= htmlspecialchars($animeItem['score'], ENT_QUOTES, 'UTF-8') ?></p>
                        <a href="/anime/detail/<?= $animeItem['mal_id'] ?>" class="btn btn-primary">More Info</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- top score anime -->
    <!-- up coming anime -->
    <div class="row py-3">
        <div class="col-6">
            <h2>Up Coming Anime</h2>
        </div>
        <div class="col d-flex justify-content-end align-items-center">
            <a href="/anime/search?status=upcoming&type=tv&sort=desc" class="link">More</a>
        </div>
    </div>
    <div class="row py-3">
        <div class="anime-slide col-12 gap-3 d-flex overflow-x-scroll ">
            <?php foreach ($upComing as $animeItem): ?>
                <div class="card col-6" style="width: 16rem;">
                    <img src="<?= $animeItem['images']['webp']['image_url'] ?>" loading="lazy" class="card-img-top"
                        alt="image <?= $animeItem['title'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($animeItem['title'], ENT_QUOTES, 'UTF-8') ?></h5>
                        <a href="/anime/detail/<?= $animeItem['mal_id'] ?>" class="btn btn-primary">More Info</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end tile -->
    <!--  comented anime -->
    <?php if ($comented): ?>

        <div class="row py-3">
            <div class="col-6">
                <h2>Top Commented Anime</h2>
            </div>
        </div>
        <div class="row py-3">
            <div class="anime-slide col-12 gap-3 d-flex overflow-x-scroll ">
              <?php foreach ($comented as $animeItem): ?>
                  <div class="card col-6" style="width: 16rem;">
                      <img src="<?= $animeItem['images']['webp']['image_url'] ?>" loading="lazy" class="card-img-top"
                           alt="image <?= $animeItem['title'] ?>">
                      <div class="card-body">
                          <h5 class="card-title"><?= htmlspecialchars($animeItem['title'], ENT_QUOTES, 'UTF-8') ?></h5>
                          <p class="card-text"><?= htmlspecialchars($animeItem['score'], ENT_QUOTES, 'UTF-8') ?></p>
                          <a href="/anime/detail/<?= $animeItem['mal_id'] ?>" class="btn btn-primary">More Info</a>
                      </div>
                  </div>
              <?php endforeach; ?>
            </div>
        </div>

    <?php endif; ?>
    <!-- end  -->
</div>
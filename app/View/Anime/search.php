<?php
$anime = $model['anime']['data'] ?? [];
$pagination = $model['anime']['pagination'] ?? ['last_visible_page' => 1];
$lastPage = $pagination['last_visible_page'];

// Ambil halaman dari query string, pastikan minimal 1
$page = max((int) ($_GET['page'] ?? 1), 1);

// Parsing query string tanpa 'page' agar parameter lain tetap dipertahankan
$queryParams = $_GET;
unset($queryParams['page']);

// Navbar
include_once __DIR__ . "/../Components/navbar.php";
?>

<div class="container ">
    <?php include_once __DIR__ . "/../Components/search.php"; ?>
    <div class="row py-2">
        <div class="col">
            <?= isset($_GET["title"]) ? 'Search of ' . $_GET['title'] : "Search Anime" ?>
        </div>
    </div>
    <div class="row d-flex">
        <?php foreach ($anime as $animeItem): ?>
            <div class="col">
                <div class="card" style="width: 16rem;">
                    <img src="<?= htmlspecialchars($animeItem['images']['webp']['image_url']) ?>" class="card-img-top"
                        alt="image <?= htmlspecialchars($animeItem['title']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($animeItem['title'], ENT_QUOTES, 'UTF-8') ?></h5>
                        <?php if(isset($animeItem['score'])) : ?>
                        <p class="card-text">Global Score <?= htmlspecialchars($animeItem['score'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>
                        <a href="/anime/detail/<?= $animeItem['mal_id'] ?>" class="btn btn-primary">More Info</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row py-5">
        <div class="col d-flex justify-content-center gap-1">
            <?php if ($page > 1): ?>
                <!-- Link Previous jika halaman > 1 -->
                <a href="<?= '?' . http_build_query(array_merge($queryParams, ['page' => $page - 1])) ?>"
                    class="btn btn-secondary">Previous</a>
            <?php endif; ?>

            <?php if ($page < $lastPage): ?>
                <!-- Link Next jika halaman belum mencapai last visible page -->
                <a href="<?= '?' . http_build_query(array_merge($queryParams, ['page' => $page + 1])) ?>"
                    class="btn btn-secondary">Next</a>
            <?php endif; ?>
        </div>
    </div>
</div>
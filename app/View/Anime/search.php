<!-- Navbar -->
<?php include_once __DIR__ . '/../Components/navbar.php'; ?>
<style>
    .card-size {
        width: 100%;
        min-width: 150px; /* Minimum width to keep layout */
        height: 250px;
        background-size: cover;
        background-position: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
    }

    .card-body {
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.6), rgba(255, 255, 255, 0.1));
    }

    .card-title {
        font-weight: 800;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .card:hover .card-title {
        white-space: normal;
        overflow: visible;
        animation: expand 0.3s ease-in-out;
    }

    /* Animation for card text expand */
    @keyframes expand {
        from {
            opacity: 0;
            transform: translateY(5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<div class="container">
    <?php include_once __DIR__ . "/../Components/search.php"; ?>

    <div class="row py-5">
        <div class="col d-flex justify-content-end gap-1">
            <!-- Pagination Button -->
            <button id="prevButton" class="btn btn-secondary" disabled>Previous</button>
            <button id="nextButton" class="btn btn-secondary" disabled>Next</button>
        </div>
    </div>

    <!-- Responsive card layout -->
    <div class="row d-flex flex-wrap row-cols-lg-5 row-cols-sm-2 row-cols-md-3 g-3" id="animeList">
        <!-- Placeholder Anime Cards -->
        <?php for ($i = 1; $i <= 20; $i++) : ?>
            <a href="#" class="text-decoration-none col my-1">
                <div class="card card-size"
                     style="background-image: url('/images/dummy.svg')">
                    <div class="card-body d-flex justify-content-start align-content-end flex-column-reverse">
                        <h6 class="card-title fw-bold text-white placeholder">title of the cards</h6>
                    </div>
                </div>
            </a>
        <?php endfor; ?>
    </div>
</div>

<script src="/script/fetchapi.js"></script>
<script>
    function renderAnimeList(animeList) {
        $("#animeList").html("");

        animeList.forEach(function (anime) {
            let animeCard = `
                <a href="/anime/detail/${anime.mal_id}" class="text-decoration-none col my-1">
                    <div class="card card-size "
                         style="background-image: url('${anime.images.webp.image_url}')">
                        <div class="card-body d-flex justify-content-start align-content-end flex-column-reverse">
                            <h6 class="card-title fw-bold text-white">${anime.title}</h6>
                             <p class="card-meta fw-medium text-white">${anime.score ? "Global : " + anime.score : ""}</p>
                        </div>
                    </div>
                </a>
            `;
            $("#animeList").append(animeCard);
        });
    }

    $(document).ready(function () {
        let page = 1;
        let lastPage = 1;

        function loadAnime(page) {
            const params = {
                q: getQueryParam('title'),
                type: getQueryParam("type"),
                min_score: getQueryParam("score"),
                order_by: getQueryParam("order_by"),
                status: getQueryParam("status"),
                rating: getQueryParam("rating"),
                sort: getQueryParam("sort") || "desc",
                genres: getQueryParam("genres"),
                page: page,
            };
            // fetchanime dari folder script
            fetchAnime("?sfw=true&", params, function (response) {
                lastPage = response.pagination.last_visible_page;
                renderAnimeList(response.data);

                // Update pagination button
                $("#prevButton").prop("disabled", page <= 1);
                $("#nextButton").prop("disabled", page >= lastPage);
            }, function () {
                Swal.fire("YOO santai santai!!!");
            });
        }

        // Pencarian anime
        $("#searchButton").click(function () {
            page = 1; // Reset ke halaman pertama jika ada pencarian
            loadAnime(page);
        });

        // Navigasi pagination
        $("#prevButton").click(function () {
            if (page > 1) {
                page--;
                loadAnime(page);
            }
        });

        $("#nextButton").click(function () {
            if (page < lastPage) {
                page++;
                loadAnime(page);
            }
        });

        // Load data anime pertama kali
        loadAnime(page);
    });
</script>

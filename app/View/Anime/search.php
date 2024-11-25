<!-- Navbar -->
<?php include_once __DIR__ . '/../Components/navbar.php'; ?>
<style>
    /* Mobile devices (up to 600px) */
    @media only screen and (max-width: 600px) {
        .card-size {
            width: calc(50vw - 1rem); /* 2 column layout */
            height: calc((50vw - 1rem));
        }

        .card-meta {
            display: none;
        }
    }

    /* Tablet devices (601px to 900px) */
    @media only screen and (min-width: 601px) and (max-width: 900px) {
        .card-size {
            width: calc(25vw - 1rem); /* 3 column layout */
            height: calc(3 / 4 * (33.33vw - 1rem));
        }
    }

    /* PC devices (901px and above) */
    @media only screen and (min-width: 901px) {
        .card-size {
            width: calc(20vw - 1rem); /* 4 or more column layout */
            height: calc(3 / 4 * (25vw - 1rem));
        }
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
        /*text-transform: uppercase;*/
        /*font-weight: 500;*/
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
</style>
<div class="container">
    <?php include_once __DIR__ . "/../Components/search.php"; ?>

    <div class="row pb-5 px-md-2" id="pagination">
        <div class="col">
            <p>Page <span class="page-num"></span></p>
        </div>
        <div class="col d-flex justify-content-end gap-1">
            <!-- Pagination Button -->
            <button class="btn btn-secondary prevButton" disabled>Previous</button>
            <button class="btn btn-secondary nextButton" disabled>Next</button>
        </div>
    </div>

    <!-- Responsive card layout -->
    <div class="row justify-content-center" id="animeList">
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

    <!--    -->
    <div class="row py-5 px-md-2">
        <div class="col">
            <p>Page <span class="page-num"></span></p>
        </div>
        <div class="col d-flex justify-content-end gap-1">
            <!-- Pagination Button -->
            <button id="prevButton" class="btn btn-secondary prevButton" disabled>Previous</button>
            <button id="nextButton" class="btn btn-secondary nextButton" disabled>Next</button>
        </div>
    </div>
</div>

<script src="/script/fetchapi.js"></script>
<script>
    function renderAnimeList(animeList) {
        $("#animeList").html("");

        animeList.forEach(function (anime) {
            let animeCard = `
                <a href="/anime/detail/${anime.mal_id}" class="text-decoration-none col-6 col-sm col-md col-lg d-flex justify-content-center py-2">
                    <div class="card card-size "
                         style="background-image: url('${anime.images.webp.image_url}')">
                        <div class="card-body d-flex justify-content-start align-content-end flex-column-reverse">
                            <h6 class="card-title fw-bold text-white">${anime.title}</h6>
                            <p class="card-meta fw-lighter text-white">Score ${anime.score ? "Global : " + anime.score : ""}</p>
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
                $(".prevButton").prop("disabled", page <= 1);
                $(".nextButton").prop("disabled", page >= lastPage);
                $(".page-num").text(page);
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
        $(".prevButton").click(function () {
            if (page > 1) {
                page--;
                loadAnime(page);
            }
        });

        $(".nextButton").click(function () {
            if (page < lastPage) {
                page++;
                loadAnime(page);
            }
        });

        // Load data anime pertama kali
        loadAnime(page);
    });
</script>

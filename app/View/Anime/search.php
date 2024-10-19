<?php
include_once __DIR__ . '/../Components/navbar.php';
?>

<div class="container">
    <?php include_once __DIR__ . "/../Components/search.php"; ?>

    <div class="row py-5">
        <div class="col d-flex justify-content-end gap-1">
            <!-- Pagination Button -->
            <button id="prevButton" class="btn btn-secondary" disabled>Previous</button>
            <button id="nextButton" class="btn btn-secondary" disabled>Next</button>
        </div>
    </div>

    <div class="row d-flex" id="animeList">
        <!-- anime -->
    </div>

</div>

<script>
    function getQueryParam(name) {
        let urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    $(document).ready(function() {
        let page = 1;
        let lastPage = 1;

        function loadAnime(page) {
            $.ajax({
                url: `https://api.jikan.moe/v4/anime?sfw=true&`,
                method: 'GET',
                data: {
                    q: getQueryParam('title'),
                    type :  getQueryParam("type"),
                    min_score : getQueryParam("score"),
                    order_by: getQueryParam("order_by"),
                    status : getQueryParam("status"),
                    rating : getQueryParam("rating"),
                    sort : getQueryParam("sort") || "desc",
                    genre : getQueryParam("genres"),
                    page,
                },
                success: function(response) {
                    // Reset list anime
                    $("#animeList").html("");

                    // Menampilkan anime dalam kartu
                    let animeList = response.data;
                    lastPage = response.pagination.last_visible_page;

                    animeList.forEach(function(anime) {
                        let animeCard = `
                        <div class="col">
                            <div class="card" style="width: 16rem;">
                                <img src="${anime.images.webp.image_url}" class="card-img-top" alt="image ${anime.title}">
                                <div class="card-body">
                                    <h5 class="card-title">${anime.title}</h5>
                                    ${anime.score ? `<p class="card-text">Global Score ${anime.score}</p>` : ''}
                                    <a href="/anime/detail/${anime.mal_id}" class="btn btn-primary">More Info</a>
                                </div>
                            </div>
                        </div>
                    `;
                        $("#animeList").append(animeCard);
                    });

                    // Update pagination button
                    $("#prevButton").prop("disabled", page <= 1);
                    $("#nextButton").prop("disabled", page >= lastPage);
                },
                error: function() {
                    Swal.fire("YOO santai santai!!!");
                }
            });
        }

        // Pencarian anime
        $("#searchButton").click(function() {
            page = 1; // Reset ke halaman pertama jika ada pencarian
            loadAnime(page);
        });

        // Navigasi pagination
        $("#prevButton").click(function() {
            if (page > 1) {
                page--;
                loadAnime(page);
            }
        });

        $("#nextButton").click(function() {
            if (page < lastPage) {
                page++;
                loadAnime(page);
            }
        });

        // Load data anime pertama kali
        loadAnime(page);
    });
</script>


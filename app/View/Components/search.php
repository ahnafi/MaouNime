<?php
$genres = [
    ["id" => 1, "genre" => "Action"],
    ["id" => 2, "genre" => "Adventure"],
    ["id" => 4, "genre" => "Comedy"],
    ["id" => 8, "genre" => "Drama"],
    ["id" => 10, "genre" => "Fantasy"],
    ["id" => 14, "genre" => "Horror"],
    ["id" => 7, "genre" => "Mystery"],
    ["id" => 22, "genre" => "Romance"],
    ["id" => 24, "genre" => "Sci-Fi"],
    ["id" => 36, "genre" => "Slice of Life"],
    ["id" => 30, "genre" => "Sports"],
    ["id" => 37, "genre" => "Supernatural"],
    ["id" => 39, "genre" => "Detective"],
    ["id" => 58, "genre" => "Gore"],
    ["id" => 13, "genre" => "Historical"],
    ["id" => 62, "genre" => "Isekai"],
    ["id" => 17, "genre" => "Martial Arts"],
    ["id" => 67, "genre" => "Medical"],
    ["id" => 38, "genre" => "Military"],
    ["id" => 19, "genre" => "Music"],
    ["id" => 6, "genre" => "Mythology"],
    ["id" => 40, "genre" => "Psychological"],
    ["id" => 23, "genre" => "School"],
    ["id" => 31, "genre" => "Super Power"],
    ["id" => 76, "genre" => "Survival"],
    ["id" => 79, "genre" => "Video Game"],
    ["id" => 43, "genre" => "Josei"],
    ["id" => 15, "genre" => "Kids"],
    ["id" => 42, "genre" => "Seinen"],
    ["id" => 25, "genre" => "Shoujo"],
    ["id" => 27, "genre" => "Shounen"],
];
?>
<div class="row my-3 d-flex justify-content-center">
    <form id="searchForm" method="get" action="/anime/search" class="col-12 col-md-8 col-lg-6 col-xl-4 "
          role="search">
        <div class="d-flex gap-1">
            <input class="form-control me-2 " type="search" name="title" placeholder="Search anime..."
                   aria-label="Search" required value="<?= $_GET['title'] ?? '' ?>">
            <button class="btn btn-outline-success d-flex justify-content-center align-items-center" type="submit">
                <img src="/images/icons/search.svg" alt="search">
            </button>
            <button class="btn btn-outline-success d-flex justify-content-center align-items-center" type="button"
                    data-bs-toggle="modal" data-bs-target="#filterModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
                </svg>
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalFilterLabel">Filter search</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- type -->
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="type">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option selected value="">--Select Type--</option>
                                <option value="tv">TV</option>
                                <option value="movie">Movie</option>
                                <option value="ova">OVA</option>
                                <option value="special">Special</option>
                                <option value="ona">ONA</option>
                                <option value="music">Music</option>
                                <option value="cm">CM</option>
                                <option value="pv">PV</option>
                                <option value="tv_special">TV Special</option>
                            </select>
                        </div>

                        <!-- score -->
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="score">Score</label>
                            <input class="form-control" type="number" id="score" name="score" min="0" max="10"
                                   step="0.1" placeholder="Min Score">
                        </div>
                        <!-- Filter Status -->
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="status">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">--Select Status--</option>
                                <option value="airing">Airing</option>
                                <option value="complete">Complete</option>
                                <option value="upcoming">Upcoming</option>
                            </select>
                        </div>

                        <!-- Filter Rating -->
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="rating">Rating</label>
                            <select class="form-select" id="rating" name="rating">
                                <option value="">--Select Rating--</option>
                                <option value="g">G - All Ages</option>
                                <option value="pg">PG - Children</option>
                                <option value="pg13">PG-13 - Teens 13 or older</option>
                                <option value="r17">R - 17+ (violence & profanity)</option>
                            </select>
                        </div>
                        <!-- Genre -->
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="genre">Genre</label>
                            <select class="form-select" id="genre" name="genres">
                                <option value="">--Select Genre--</option>
                                <?php foreach ($genres as $genre ): ?>
                                <option value="<?= $genre["id"] ?>"><?= $genre["genre"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('searchForm').addEventListener('submit', function (e) {
        const inputs = this.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (!input.value) {
                input.disabled = true; // Disable input if it's empty
            }
        });
    });
</script>

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

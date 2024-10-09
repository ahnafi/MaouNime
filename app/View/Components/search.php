<div class="row my-3">
    <div class="col-12 d-flex justify-content-center">
        <form id="searchForm" method="get" action="/anime/search" class="" role="search">
            <div class="d-flex gap-1">
                <input class="form-control me-2" type="search" name="title" placeholder="Search anime..." aria-label="Search" required>
                <button class="btn btn-outline-success" type="submit">Search</button>
                <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                    \/
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
                                <input class="form-control" type="number" id="score" name="score" min="0" max="10" step="0.1" placeholder="Min Score">
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
</div>

<script>
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        const inputs = this.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (!input.value) {
                input.disabled = true; // Disable input if it's empty
            }
        });
    });
</script>

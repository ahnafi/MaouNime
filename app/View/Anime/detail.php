<?php

$anime = $model['anime']['data'] ?? [];
$comments = $model['comments'] ?? [];
$rating = $model['rating']->rating ?? null;
$score = $model['rating']->score ?? null;
$localScore = $rating->rating ?? 0;

// navbar taruh di awal php biar gak error
include_once __DIR__ . "/../Components/navbar.php";
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-4">
            <!-- Poster Anime -->
            <img src="<?= $anime['images']['webp']['large_image_url'] ?>" alt="<?= $anime['title'] ?>"
                 class="img-fluid rounded">
        </div>
        <div class="col-md-8">
            <!-- Detail Anime -->
            <h2><?= $anime['title'] ?></h2>
            <p><strong>Type:</strong> <?= $anime['type'] ?></p>
            <p><strong>Status:</strong> <?= $anime['status'] ?></p>
            <p><strong>Episodes:</strong> <?= $anime['episodes'] ?></p>
            <p><strong>Global Score:</strong> <?= $anime['score'] ?></p>
            <p><strong>Score:</strong> <?= $score ?? '0' ?></p>
            <p><strong>Synopsis:</strong> <?= $anime['synopsis'] ?></p>

            <?php if (isset($model['user'])) : ?>
                <div class="d-flex gap-3">
                    <!-- Watchlist Button -->
                    <form action="/anime/watchlist" method="POST">
                        <input type="hidden" name="animeId" value="<?= $anime['mal_id'] ?>">
                        <input type="hidden" name="img" value="<?= $anime['images']['webp']['image_url'] ?>">
                        <input type="hidden" name="animeTitle" value="<?= $anime['title'] ?>">
                        <button type="submit" class="btn btn-primary">Add to Watchlist</button>
                    </form>

                    <form action="/anime/rating" method="post" id="ratingForm" class="col-2">
                        <select name="rating" class="form-select" aria-label="Default select example"
                                onchange="submitRatingForm()">
                            <option value="10" <?= $localScore === 10 ? 'selected' : '' ?>>10</option>
                            <option value="9" <?= $localScore === 9 ? 'selected' : '' ?>>9</option>
                            <option value="8" <?= $localScore === 8 ? 'selected' : '' ?>>8</option>
                            <option value="7" <?= $localScore === 7 ? 'selected' : '' ?>>7</option>
                            <option value="6" <?= $localScore === 6 ? 'selected' : '' ?>>6</option>
                            <option value="5" <?= $localScore === 5 ? 'selected' : '' ?>>5</option>
                            <option value="4" <?= $localScore === 4 ? 'selected' : '' ?>>4</option>
                            <option value="3" <?= $localScore === 3 ? 'selected' : '' ?>>3</option>
                            <option value="2" <?= $localScore === 2 ? 'selected' : '' ?>>2</option>
                            <option value="1" <?= $localScore === 1 ? 'selected' : '' ?>>1</option>
                            <?php if ($localScore == 0) : ?>
                                <option value="0" selected>0</option>
                            <?php endif; ?>
                        </select>
                        <input type="hidden" name="animeId" value="<?= $anime["mal_id"] ?>">
                        <input type="hidden" name="animeTitle" value="<?= $anime["title"] ?>">
                    </form>
                </div>
            <?php endif; ?>

        </div>
        <!-- Comments Section -->
        <div class="mt-4">
            <h4>Comments <span class=""><?= count($comments) != 0 ? count($comments) : "" ?></span></h4>
            <?php if (isset($model['user'])) : ?>
                <form action="/anime/comment" method="POST" class="mb-3" onsubmit="return validateComment()">
                    <!-- Hidden input for anime ID -->
                    <input type="hidden" name="animeId"
                           value="<?= htmlspecialchars($anime['mal_id'], ENT_QUOTES, 'UTF-8') ?>">

                    <!-- Hidden input for anime title -->
                    <input type="hidden" name="animeTitle"
                           value="<?= htmlspecialchars($anime['title'], ENT_QUOTES, 'UTF-8') ?>">

                    <div class="form-group ">
                        <label for="comment">Add a Comment:</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" maxlength="500"
                                  required></textarea>
                    </div>

                    <button type="submit" class="btn btn-secondary my-2">Submit Comment</button>
                </form>
            <?php endif; ?>

            <!-- Display Existing Comments -->
            <?php if (!empty($comments)): ?>
                <ul class="list-group">
                    <?php foreach ($comments as $comment): ?>
                        <li class="list-group-item d-flex align-items-center ">
                            <p class="col-8">
                                <strong><?= htmlspecialchars($comment->userId) ?>:</strong>
                                <?= htmlspecialchars($comment->comment) ?>
                            </p>
                            <span class="col text-end "><?= $comment->commentedAt ?></span>

                            <form action="/anime/comment/delete" method="post"
                                  class="col-1 d-flex justify-content-center" onsubmit="return handleDelete(event)">
                                <input type="hidden" name="animeId" value="<?= $comment->animeId ?>">
                                <input type="hidden" name="commentId" value="<?= $comment->id ?>">
                                <button class="btn btn-outline-<?= $model['user']['id'] == $comment->userId ? "danger" : 'seccondary' ?>" <?= $model['user']['id'] == $comment->userId ? "" : 'disabled' ?> >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </button>
                            </form>

                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No comments yet. Be the first to comment!</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function submitRatingForm() {
        document.getElementById('ratingForm').submit();
    }

    function validateComment() {
        const commentField = document.getElementById('comment');
        const commentLength = commentField.value.length;

        if (commentLength > 500) {
            alert('Comment cannot exceed 500 characters.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }

    function alertConfirm() {
        return Swal.fire({
            title: "Perhatian",
            text: "Apakah kamu ingin menghapus komentar ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Iya",
            cancelButtonText: "Batal"
        }).then((result) => {
            return result.isConfirmed; // Hanya mengembalikan true jika pengguna mengklik "Iya"
        });
    }

    async function handleDelete(event) {
        event.preventDefault(); // Mencegah form submit langsung
        const confirmed = await alertConfirm(); // Tunggu hasil konfirmasi
        if (confirmed) {
            event.target.submit(); // Submit form jika dikonfirmasi
        }
    }
</script>